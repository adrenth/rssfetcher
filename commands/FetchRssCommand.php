<?php

declare(strict_types=1);

namespace Adrenth\RssFetcher\Commands;

use Adrenth\RssFetcher\Classes\Reader\Extension\Media\Entry;
use Adrenth\RssFetcher\Models\Item;
use Adrenth\RssFetcher\Models\Source;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Log;
use Symfony\Component\Console\Input\InputArgument;
use System\Models\File;
use Zend\Feed\Reader\Entry\Rss;
use Zend\Feed\Reader\Reader;
use Zend\Http\Client;

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
     * @deprecated Will be dropped when OctoberCMS supports Laravel 5.5
     * @return void
     * @throws \RuntimeException
     * @throws Exception
     */
    public function handle()
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

                /** @var Rss $entry */
                foreach ($channel as $entry) {
                    ++$itemCount;

                    $this->getOutput()->writeln($itemCount . '. ' . $entry->getTitle());

                    $dateCreated = $entry->getDateCreated();

                    $attributes = [
                        'item_id' => $entry->getId(),
                        'source_id' => $source->getAttribute('id'),
                        'title' => $entry->getTitle(),
                        'link' => $entry->getLink(),
                        'description' => strip_tags($entry->getContent()),
                        'category' => implode(', ', $entry->getCategories()->getValues()),
                        'comments' => $entry->getCommentLink(),
                        'pub_date' => $dateCreated !== null ? $entry->getDateCreated()->format('Y-m-d H:i:s') : null,
                        'is_published' => $source->getAttribute('publish_new_items')
                    ];

                    if ($entry->getAuthors() !== null && is_array($entry->getAuthors())) {
                        $attributes['author'] = implode(', ', $entry->getAuthors());
                    }

                    $item = Item::firstOrCreate($attributes);

                    $this->extractImagesFromEntry($item, $entry);

                    if ($maxItems > 0 && $itemCount >= $maxItems) {
                        break;
                    }
                }

                $source->setAttribute('fetched_at', new Carbon());
                $source->save();

            } catch (Exception $e) {
                Log::error($e);
                $this->getOutput()->writeln('<error>' . $e->getMessage() . '</error>');
            }
        });
    }

    /**
     * @param Item $item
     * @param Rss $entry
     * @throws \Zend\Http\Exception\RuntimeException
     * @throws \Zend\Http\Client\Exception\RuntimeException
     */
    private function extractImagesFromEntry(Item $item, Rss $entry)
    {
        /** @var Entry $extension */
        $extension = $entry->getExtension('Media');

        if ($extension === null || $extension->getMediaContentMedium() !== 'image') {
            return;
        }

        $url = $extension->getMediaContentUrl();

        if ($url === null || $url === '') {
            return;
        }

        $this->downloadImageAndAttachToItem($item, $url);
    }

    /**
     * @param Item $item
     * @param string $url
     * @throws \Zend\Http\Exception\RuntimeException
     * @throws \Zend\Http\Client\Exception\RuntimeException
     */
    private function downloadImageAndAttachToItem(Item $item, string $url)
    {
        $response = (new Client($url))->send();

        if ($response->isSuccess()) {
            $file = (new File)->fromData($response->getBody(), md5($url));
            $item->images()->add($file);
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function getArguments(): array
    {
        return [
            ['source', InputArgument::OPTIONAL, 'Source ID'],
        ];
    }
}
