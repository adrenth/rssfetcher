<?php

namespace Adrenth\RssFetcher\Models;

use Model;
use October\Rain\Database\Traits\Validation;

/**
 * Source Model
 */
class Source extends Model
{
    use Validation;

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
     * Validation rules
     *
     * @type array
     */
    public $rules = [
        'name' => 'required',
        'source_url' => 'required',
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
