<?php

namespace Adrenth\RssFetcher\Updates;

use Illuminate\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use Schema;

/**
 * Class AddPublishColumns
 *
 * @package Adrenth\RssFetcher\Updates
 */
class AddPublishColumns extends Migration
{
    public function up()
    {
        Schema::table('adrenth_rssfetcher_items', function (Blueprint $table) {
            $table->boolean('is_published')->default(true);
        });

        Schema::table('adrenth_rssfetcher_sources', function (Blueprint $table) {
            $table->boolean('publish_new_items')->default(true);
        });
    }

    public function down()
    {
        Schema::table('adrenth_rssfetcher_items', function (Blueprint $table) {
            $table->dropColumn('is_published');
        });

        Schema::table('adrenth_rssfetcher_sources', function (Blueprint $table) {
            $table->dropColumn('publish_new_items');
        });
    }
}
