<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_categories', function (Blueprint $table) {
            $table->id();
            ///$table->increments('id');
            $table->bigInteger('parent_id')->unsigned()->default(1);
            //slug i title для постройки url
            $table->string('slug')->unique();
            $table->string('title');
            $table->text('description')->nullable();
            //createad updatead  когда создана, последний раз изменена:
            $table->timestamps();
            //deletead когда запись была удалена
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog_categories');
    }
}
