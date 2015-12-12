<?php

namespace Adrenth\RssFetcher\Updates;

use Adrenth\RssFetcher\Models\Source;
use October\Rain\Database\Updates\Seeder;

/**
 * Class SeedAllTables
 *
 * @package Adrenth\RssFetcher\Updates
 */
class SeedAllTables extends Seeder
{
    /**
     * {@inheritdoc}
     */
    public function run()
    {
        Source::create([
            'name' => 'NU.nl | Algemeen nieuws',
            'description' => 'NU.nl | Algemeen nieuws',
            'source_url' => 'http://www.nu.nl/rss/Algemeen',
            'max_items' => 0,
            'is_enabled' => true,
        ]);
        Source::create([
            'name' => 'NU.nl | Internet',
            'description' => 'NU.nl | Internet',
            'source_url' => 'http://www.nu.nl/rss/Internet',
            'max_items' => 0,
            'is_enabled' => true,
        ]);
    }
}
