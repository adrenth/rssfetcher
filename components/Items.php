<?php

namespace Adrenth\RssFetcher\Components;

use Adrenth\RssFetcher\Models\Item;
use Cms\Classes\ComponentBase;
use DB;
use October\Rain\Support\Collection;

/**
 * Class Items
 *
 * @package Adrenth\RssFetcher\Components
 */
class Items extends ComponentBase
{
    /**
     * @type Collection
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
    public function defineProperties()
    {
        return [
            'maxItems' => [
                'label' => 'adrenth.rssfetcher::lang.item.max_items',
                'type' => 'string',
                'default' => '10'
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function onRun()
    {
        $this->items = self::loadItems($this->property('maxItems'));
    }

    /**
     * Load Items
     *
     * @param int $maxItems
     * @return array|static[]
     */
    public static function loadItems($maxItems = 10)
    {
        try {
            $items = Item::select(['adrenth_rssfetcher_items.*', 'adrenth_rssfetcher_sources.name AS source'])
                ->join('adrenth_rssfetcher_sources', 'adrenth_rssfetcher_items.source_id', '=', 'adrenth_rssfetcher_sources.id')
                ->where('adrenth_rssfetcher_sources.is_enabled', '=', 1)
                ->where('adrenth_rssfetcher_items.is_published', '=', 1)
                ->orderBy('adrenth_rssfetcher_items.pub_date', 'desc')
                ->limit($maxItems);
        } catch (\InvalidArgumentException $e) {
            return [];
        }

        return $items->get();
    }
}