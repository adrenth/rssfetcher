<?php

namespace Adrenth\RssFetcher\Models;

use Model;

/**
 * Source Model
 */
class Source extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'adrenth_rssfetcher_sources';

    /**
     * {@inheritdoc}
     */
    protected $guarded = ['*'];

    /**
     * {@inheritdoc}
     */
    protected $fillable = [];

    /**
     * {@inheritdoc}
     */
    protected $dates = [
        'fetched_at'
    ];

    /**
     * {@inheritdoc}
     */
    public $hasMany = [
        'items' => [
            'Adrenth\RssFetcher\Models\Item',
        ],
        'items_count' => [
            'Adrenth\RssFetcher\Models\Item',
            'count' => true
        ]
    ];
}
