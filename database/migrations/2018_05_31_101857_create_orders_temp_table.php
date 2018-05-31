<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTempTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        $tableName = Config::get('migrations.OrdersTemp');

        echo "CreateOrdersTempTable\r\n";

        Schema::create($tableName, function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->increments('id')->index();
            $table->longText('data')->nullable();
            $table->timestamps();
        });
    }
}
