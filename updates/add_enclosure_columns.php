<?php

declare(strict_types=1);

namespace Adrenth\RssFetcher\Updates;

use Illuminate\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use Schema;

/** @noinspection AutoloadingIssuesInspection */

/**
 * Class AddEnclosureColumn
 *
 * @package Adrenth\RssFetcher\Updates
 */
class AddEnclosureColumn extends Migration
{
    public function up()
    {
        Schema::table('adrenth_rssfetcher_items', function (Blueprint $table) {
            $table->string('enclosure_type')
                ->nullable()
                ->after('comments');
            $table->unsignedInteger('enclosure_length')
                ->nullable()
                ->after('comments');
            $table->mediumText('enclosure_url')
                ->nullable()
                ->after('comments');
        });
    }

    public function down()
    {
        Schema::table('adrenth_rssfetcher_items', function (Blueprint $table) {
            $table->dropColumn([
                'enclosure_url',
                'enclosure_length',
                'enclosure_type'
            ]);
        });
    }
}
