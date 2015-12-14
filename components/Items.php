<?php

namespace Adrenth\RssFetcher\Components;

use Cms\Classes\ComponentBase;
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
            'name' => 'Item List',
            'description' => 'Displays a list of latest RSS items on the page.'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function defineProperties()
    {
        return [
            'maxItems' => [
                'label' => 'Max Items',
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
        $this->items = $this->page['items'] = self::loadItems($this->property('maxItems'));
    }

    /**
     * List Items
     *
     * @param int $maxItems
     * @return array|static[]
     */
    public static function loadItems($maxItems = 10)
    {
        try {
            $items = \Db::table('adrenth_rssfetcher_items')
                ->select([
                    'adrenth_rssfetcher_items.*',
                    'adrenth_rssfetcher_sources.name AS source'
                ])
                ->join('adrenth_rssfetcher_sources', 'adrenth_rssfetcher_items.source_id', '=', 'adrenth_rssfetcher_sources.id')
                ->where('adrenth_rssfetcher_sources.is_enabled', '=', 1)
                ->orderBy('adrenth_rssfetcher_items.pub_date', 'desc')
                ->limit($maxItems);
        } catch (\InvalidArgumentException $e) {
            return [];
        }

        return $items->get();
    }
}