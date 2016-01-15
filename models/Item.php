<?php

namespace Adrenth\RssFetcher\Models;

use Model;

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
    protected $guarded = ['*'];

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
        'source' => 'Adrenth\RssFetcher\Models\Source'
    ];

    /**
     * Allows filtering for specifc sources
     *
     * @param October\Rain\Database\Builder $query QueryBuilder
     * @param array $sources List of source ids
     * @return October\Rain\Database\Builder
     */
    public function scopeFilterSources($query, array $sources = [])
    {
        return $query->whereHas('source', function ($q) use ($sources) {
            $q->whereIn('id', $sources);
        });
    }
}
