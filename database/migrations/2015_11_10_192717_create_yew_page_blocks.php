<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateYewPageBlocks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yew_page_blocks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('page_id')->unsigned();
            $table->integer('sort_order');
            $table->integer('margin_top');
            $table->integer('margin_right');
            $table->integer('margin_bottom');
            $table->integer('margin_left');
            $table->integer('padding_top');
            $table->integer('padding_right');
            $table->integer('padding_bottom');
            $table->integer('padding_left');
            $table->string('class', 500);
            $table->string('columns', 20);
            $table->boolean('fullwidth');
            $table->timestamps();

            $table->foreign('page_id')->references('id')->on('yew_pages')->onDelete('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('yew_page_blocks');
    }
}
