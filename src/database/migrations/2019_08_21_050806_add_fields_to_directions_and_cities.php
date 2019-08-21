<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToDirectionsAndCities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('directions', function (Blueprint $table) {
            $table->string('city_code_from')->nullable();
            $table->string('city_code_to')->nullable();
        });

        Schema::table('cities', function (Blueprint $table) {
            $table->string('country_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('directions_and_cities', function (Blueprint $table) {
            //
        });
    }
}
