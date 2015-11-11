<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateYewMenuItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yew_menu_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('menu_id')->unsigned();
            $table->integer('page_id')->unsigned();
            $table->integer('parent_id')->unsigned();
            $table->string('page_name', 500);
            $table->string('slug', 500);
            $table->string('url', 500);
            $table->integer('sort_order');
            $table->timestamps();

            $table->foreign('menu_id')->references('id')->on('yew_menus')->onDelete('restrict')->onDelete('restrict');
            $table->foreign('page_id')->references('id')->on('yew_pages')->onDelete('restrict')->onDelete('restrict');
        });

        Schema::table('yew_menu_items', function (Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on('yew_menu_items')->onDelete('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('yew_menu_items');
    }
}
