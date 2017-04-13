<?php

namespace Adrenth\RssFetcher\Updates;

use Illuminate\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use Schema;

/**
 * Class CreateItemsTable
 *
 * @package Adrenth\RssFetcher\Updates
 */
class CreateItemsTable extends Migration
{
    public function up()
    {
        Schema::create('adrenth_rssfetcher_items', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('source_id');
            $table->string('item_id', 191)->unique('item_id_unique');
            $table->string('title')->nullable();
            $table->string('link')->nullable();
            $table->mediumText('description')->nullable();
            $table->string('author')->nullable();
            $table->mediumText('category')->nullable();
            $table->string('comments')->nullable();
            $table->dateTimeTz('pub_date')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();

            $table->foreign('source_id', 'items_source_id_foreign')
                ->references('id')
                ->on('adrenth_rssfetcher_sources')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('adrenth_rssfetcher_items');
    }
}
