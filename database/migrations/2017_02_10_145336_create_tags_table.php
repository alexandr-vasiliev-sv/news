<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::create('news_tag', function (Blueprint $table) {
            $table->unsignedInteger('news_id');
            $table->unsignedInteger('tag_id');
            $table->foreign('news_id')->references('id')->on('news');
            $table->foreign('tag_id')->references('id')->on('tags');
            $table->primary(['news_id', 'tag_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news_tag');
        Schema::dropIfExists('tags');
    }
}
