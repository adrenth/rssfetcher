<?php

namespace Adrenth\RssFetcher\Models;

use Model;
use October\Rain\Database\Builder;

/**
 * Class Item
 *
 * @package Adrenth\RssFetcher\Models
 */
class Item extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'adrenth_rssfetcher_items';

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'source_id',
        'item_id',
        'title',
        'link',
        'description',
        'author',
        'category',
        'comments',
        'pub_date',
        'is_published'
    ];

    /**
     * {@inheritdoc}
     */
    protected $dates = [
        'pub_date'
    ];

    /**
     * {@inheritdoc}
     */
    public $belongsTo = [
        'source' => Source::class
    ];

    /**
     * Allows filtering for specifc sources
     *
     * @param Builder $query
     * @param array $sources List of source ids
     * @return Builder
     */
    public function scopeFilterSources(Builder $query, array $sources = [])
    {
        return $query->whereHas('source', function ($q) use ($sources) {
            $q->whereIn('id', $sources);
        });
    }
}
