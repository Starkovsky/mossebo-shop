<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeCategoryParentIdField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        echo "ChangeCategoryParentIdField\r\n";

        Schema::table(Config::get('migrations.Categories'), function (Blueprint $table) {
            $table->integer('parent_id')->unsigned()->nullable()->change();
        });
    }
}