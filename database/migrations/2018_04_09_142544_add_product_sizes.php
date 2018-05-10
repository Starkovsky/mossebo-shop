<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProductSizes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        echo "AddProductSizes\r\n";

        Schema::table(Config::get('migrations.Products'), function (Blueprint $table) {
            $table->integer('width')->unsigned()->nullable();
            $table->integer('height')->unsigned()->nullable();
            $table->integer('length')->unsigned()->nullable();
            $table->integer('weight')->unsigned()->nullable();
        });
    }
}
