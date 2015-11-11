<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateYewPageElements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yew_page_elements', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('block_id')->unsigned();
            $table->integer('sort_order');
            $table->integer('column_width');
            $table->enum('element_type', ['html', 'image', 'video', 'widget']);
            $table->text('content');
            $table->integer('height');
            $table->integer('width');
            $table->string('alt', 500);
            $table->integer('margin_top');
            $table->integer('margin_right');
            $table->integer('margin_bottom');
            $table->integer('margin_left');
            $table->integer('padding_top');
            $table->integer('padding_right');
            $table->integer('padding_bottom');
            $table->integer('padding_left');
            $table->string('background_color', 7);
            $table->string('class', 500);
            $table->text('element_options');
            $table->timestamps();

            $table->foreign('block_id')->references('id')->on('yew_page_blocks')->onDelete('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('yew_page_elements');
    }
}
