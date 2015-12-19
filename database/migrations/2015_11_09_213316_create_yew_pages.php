<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateYewPages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yew_pages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->unsigned();
            $table->integer('revision_parent_id')->unsigned();
            $table->integer('language_id')->unsigned();
            $table->integer('language_parent_id')->unsigned();
            $table->text('title');
            $table->string('slug', 255);
            $table->text('meta_description');
            $table->text('meta_keywords');
            $table->integer('sort_order');
            $table->boolean('home_page');
            $table->integer('created_by')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('language_id')->references('id')->on('yew_languages')->onDelete('restrict')->onDelete('restrict');
        });

        Schema::table('yew_pages', function (Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on('yew_pages')->onDelete('restrict')->onDelete('restrict');
            $table->foreign('revision_parent_id')->references('id')->on('yew_pages')->onDelete('restrict')->onDelete('restrict');
            $table->foreign('language_parent_id')->references('id')->on('yew_pages')->onDelete('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('yew_pages');
    }
}
