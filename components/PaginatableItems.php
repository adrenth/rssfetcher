<?php

namespace Adrenth\RssFetcher\Components;

use Adrenth\RssFetcher\Models\Item;
use Cms\Classes\ComponentBase;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class PaginatableItems
 *
 * @package Adrenth\RssFetcher\Components
 */
class PaginatableItems extends ComponentBase
{
    /** @type LengthAwarePaginator */
    public $items;

    /**
     * {@inheritdoc}
     */
    public function componentDetails()
    {
        return [
            'name' => 'adrenth.rssfetcher::lang.component.paginatable_item_list.name',
            'description' => 'adrenth.rssfetcher::lang.component.paginatable_item_list.description'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function defineProperties()
    {
        return [
            'itemsPerPage' => [
                'title' => 'adrenth.rssfetcher::lang.item.items_per_page',
                'type' => 'string',
                'validationPattern' => '^[0-9]+$',
                'validationMessage' => 'adrenth.rssfetcher::lang.item.items_per_page_validation',
                'default' => '10',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function onRun()
    {
        $this->items = $this->loadItems();
    }

    /**
     * Load Items
     *
     * @return LengthAwarePaginator|array
     */
    protected function loadItems()
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
                 ->paginate($this->property('itemsPerPage'));
        } catch (\InvalidArgumentException $e) {
            return [];
        }

        return $items;
    }
}
