<?php

namespace Adrenth\RssFetcher\Commands;

use Adrenth\RssFetcher\Models\Item;
use Adrenth\RssFetcher\Models\Source;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Symfony\Component\Console\Input\InputArgument;
use Zend\Feed\Reader\Entry\Rss;
use Zend\Feed\Reader\Reader;

/**
 * Class FetchRssCommand
 *
 * @package Adrenth\RssFetcher\Commands
 */
class FetchRssCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected $name = 'adrenth:fetch-rss';

    /**
     * {@inheritdoc}
     */
    protected $description = 'Fetches RSS data from various sources';

    /**
     * Execute the console command.
     *
     * @return void
     * @throws \RuntimeException
     * @throws Exception
     */
    public function fire()
    {
        $sourceId = $this->argument('source');
        $sources = new Collection();

        if ($sourceId !== null && is_numeric($sourceId)) {
            $source = Source::find($sourceId);
            if ($source && $source->getAttribute('is_enabled')) {
                $sources = new Collection([$source]);
            }
        } else {
            $sources = Source::query()->where('is_enabled', '=', 1)->get();
        }

        $sources->each(function (Source $source) {
            try {
                $channel = Reader::import($source->getAttribute('source_url'));
                $maxItems = $source->getAttribute('max_items');
                $this->getOutput()->writeln($channel->getTitle());

                $itemCount = 0;

                /** @type Rss $item */
                foreach ($channel as $item) {
                    ++$itemCount;

                    $this->getOutput()->writeln($itemCount . '. ' . $item->getTitle());

                    $dateCreated = $item->getDateCreated();

                    $attributes = [
                        'item_id' => $item->getId(),
                        'source_id' => $source->getAttribute('id'),
                        'title' => $item->getTitle(),
                        'link' => $item->getLink(),
                        'description' => strip_tags($item->getContent()),
                        'category' => implode(', ', $item->getCategories()->getValues()),
                        'comments' => $item->getCommentLink(),
                        'pub_date' => $dateCreated !== null ? $item->getDateCreated()->format('Y-m-d H:i:s') : null,
                        'is_published' => $source->getAttribute('publish_new_items')
                    ];

                    if ($item->getAuthors() !== null && is_array($item->getAuthors())) {
                        $attributes['author'] = implode(', ', $item->getAuthors());
                    }

                    Item::firstOrCreate($attributes);

                    if ($maxItems > 0 && $itemCount >= $maxItems) {
                        break;
                    }
                }

                $source->setAttribute('fetched_at', new Carbon());
                $source->save();

            } catch (Exception $e) {
                $this->getOutput()->writeln('<error>' . $e->getMessage() . '</error>');
            }
        });
    }

    /**
     * {@inheritdoc}
     */
    protected function getArguments()
    {
        return [
            ['source', InputArgument::OPTIONAL, 'Source ID'],
        ];
    }
}
