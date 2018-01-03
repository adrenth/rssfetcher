<?php

declare(strict_types=1);

namespace Adrenth\RssFetcher\Components;

use Adrenth\RssFetcher\Models\Item;
use Cms\Classes\ComponentBase;
use InvalidArgumentException;
use October\Rain\Support\Collection;

/**
 * Class Items
 *
 * @package Adrenth\RssFetcher\Components
 */
class Items extends ComponentBase
{
    /**
     * @var Collection
     */
    public $items;

    /**
     * {@inheritdoc}
     */
    public function componentDetails()
    {
        return [
            'name' => 'adrenth.rssfetcher::lang.component.item_list.name',
            'description' => 'adrenth.rssfetcher::lang.component.item_list.description'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function defineProperties(): array
    {
        return [
            'maxItems' => [
                'label' => 'adrenth.rssfetcher::lang.item.max_items',
                'type' => 'string',
                'default' => '10'
            ],
            'sourceId' => [
                'label' => 'adrenth.rssfetcher::lang.item.source_id',
                'type' => 'string',
                'default' => ''
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function onRun()
    {
        $sourceId = (int) $this->property('sourceId');

        $this->items = self::loadItems(
            $this->property('maxItems'),
            $sourceId > 0 ? $sourceId : null
        );
    }

    /**
     * Load Items
     *
     * @param int $maxItems
     * @param int $sourceId
     * @return array
     */
    public static function loadItems($maxItems = 10, int $sourceId = null): array
    {
        try {
            $items = Item::select(['adrenth_rssfetcher_items.*', 'adrenth_rssfetcher_sources.name AS source'])
                ->join(
                    'adrenth_rssfetcher_sources',
                    'adrenth_rssfetcher_items.source_id',
                    '=',
                    'adrenth_rssfetcher_sources.id'
                )
                ->where('adrenth_rssfetcher_sources.is_enabled', '=', 1)
                ->where('adrenth_rssfetcher_items.is_published', '=', 1)
                ->orderBy('adrenth_rssfetcher_items.pub_date', 'desc')
                ->limit($maxItems);

            if ($sourceId !== null && is_numeric($sourceId)) {
                $items->where('adrenth_rssfetcher_items.source_id', '=', (int) $sourceId);
            }
        } catch (InvalidArgumentException $e) {
            return [];
        }

        return $items->get()->toArray();
    }
}
