<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateYewLanguages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yew_languages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('country_code', 5);
            $table->string('language_code', 10);
            $table->string('language');
        });

        Artisan::call('db:seed', ['--class' => 'YewLanguagesSeeder', '--force' => true]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('yew_languages');
    }
}
