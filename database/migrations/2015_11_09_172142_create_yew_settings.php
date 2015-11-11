<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateYewSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yew_settings', function (Blueprint $table) {
            $table->integer('id');
            $table->string('setting');
            $table->string('default_value', 500);
        });

        Artisan::call('db:seed', ['--class' => 'YewSettingsSeeder', '--force' => true]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('yew_settings');
    }
}
