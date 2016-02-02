<?php

namespace Adrenth\RssFetcher\Updates;

use Illuminate\Database\Schema\Blueprint;
use Schema;
use October\Rain\Database\Updates\Migration;

/**
 * Class CreateFeedsTable
 *
 * @package Adrenth\RssFetcher\Updates
 */
class CreateFeedsTable extends Migration
{
    public function up()
    {
        Schema::create('adrenth_rssfetcher_feeds', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->enum('type', ['rss', 'atom']);
            $table->string('title');
            $table->string('description');
            $table->string('path')->unique();
            $table->tinyInteger('max_items')->unsigned();
            $table->boolean('is_enabled');
            $table->timestamps();
        });

        Schema::create('adrenth_rssfetcher_feeds_sources', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('feed_id')->unsigned()->index();
            $table->foreign('feed_id')->references('id')->on('adrenth_rssfetcher_feeds')->onDelete('cascade');
            $table->integer('source_id')->unsigned()->index();
            $table->foreign('source_id')->references('id')->on('adrenth_rssfetcher_sources')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('adrenth_rssfetcher_feeds_sources');
        Schema::dropIfExists('adrenth_rssfetcher_feeds');
    }
}
