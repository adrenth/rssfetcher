<?php

declare(strict_types=1);

namespace Adrenth\RssFetcher\Models;

use Model;
use October\Rain\Database\Traits\Validation;

/**
 * Class Feed
 *
 * @package Adrenth\RssFetcher\Models
 */
class Feed extends Model
{
    use Validation;

    /**
     * {@inheritdoc}
     */
    public $table = 'adrenth_rssfetcher_feeds';

    /**
     * {@inheritdoc}
     */
    public $belongsToMany = [
        'sources' => [
            Source::class,
            'table' => 'adrenth_rssfetcher_feeds_sources',
            'order' => 'name',
        ],
    ];

    /** @var array */
    public $rules = [
        'title' => 'required',
        'description' => 'required',
        'path' => [
            'required',
            'regex:/^[a-z0-9\/\:_\-\*\[\]\+\?\|]*$/i',
            'unique:adrenth_rssfetcher_feeds'
        ],
        'type' => 'required'
    ];
}
