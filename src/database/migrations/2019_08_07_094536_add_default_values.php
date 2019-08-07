<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDefaultValues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contragents_1C', function($table)
        {
            $table->string('work_phone', 255)->nullable()->change();
            $table->string('email', 255)->nullable()->change();
            $table->string('fact_address', 255)->nullable()->change();
            $table->string('jur_address', 255)->nullable()->change();
            $table->string('nds_number', 255)->nullable()->change();
            $table->string('nds_date', 255)->nullable()->change();
            $table->string('bank_account', 255)->nullable()->change();
            $table->string('contract', 255)->nullable()->change();
            $table->string('manager', 255)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
