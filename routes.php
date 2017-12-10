<?php

declare(strict_types=1);

use Adrenth\RssFetcher\Models\Feed as FeedModel;
use Adrenth\RssFetcher\Models\Item;
use Adrenth\RssFetcher\Models\Source;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Response;
use Zend\Feed\Exception\InvalidArgumentException;
use Zend\Feed\Writer\Entry;
use Zend\Feed\Writer\Feed;

Route::get('/feeds/{path}', function ($path) {

    /** @var FeedModel $model */
    $model = FeedModel::where('path', '=', $path)->first();

    if ($model === null) {
        return Response::make('Not Found', 404);
    }

    $feed = new Feed();
    $feed->setTitle($model->getAttribute('title'))
        ->setDescription($model->getAttribute('description'))
        ->setBaseUrl(Url::to('/'))
        ->setGenerator('OctoberCMS/Adrenth.RssFetcher')
        ->setId('Adrenth.RssFecther.' . $model->getAttribute('id'))
        ->setLink(Url::to('/feeds/' . $path))
        ->setFeedLink(Url::to('/feeds/' . $path), $model->getAttribute('type'))
        ->setDateModified()
        ->addAuthor(['name' => 'OctoberCMS']);

    /** @var Collection $sources */
    $sources = $model->sources;
    $ids = Arr::pluck($sources->toArray(), 'id');
    $items = [];

    Source::with(['items' => function ($builder) use (&$items, $model) {
        $items = $builder->where('is_published', '=', 1)
            ->whereDate('pub_date', '<=', date('Y-m-d'))
            ->orderBy('pub_date', 'desc')
            ->limit($model->getAttribute('max_items'))
            ->get();
    }])->whereIn('id', $ids)
        ->where('is_enabled', '=', 1)
        ->get();

    /** @var Item $item */
    foreach ($items as $item) {
        try {
            $entry = new Entry();

            $entry->setId((string) $item->getAttribute('id'))
                ->setTitle($item->getAttribute('title'))
                ->setDescription($item->getAttribute('description'))
                ->setLink($item->getAttribute('link'))
                ->setDateModified($item->getAttribute('pub_date'));

            $comments = $item->getAttribute('comments');
            if (!empty($comments)) {
                $entry->setCommentLink($comments);
            }

            $category = $item->getAttribute('category');
            if (!empty($category)) {
                $entry->addCategory(['term' => $category]);
            }

            $feed->addEntry($entry);
        } catch (InvalidArgumentException $e) {
            continue;
        }
    }

    return Response::make($feed->export($model->getAttribute('type')), 200, [
        'Content-Type' => sprintf('application/%s+xml', $model->getAttribute('type')),
    ]);
});
