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
        'pub_date'
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
    public $belongsToMany = [];
}
