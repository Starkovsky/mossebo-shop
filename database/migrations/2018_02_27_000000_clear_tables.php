<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ClearTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $conn = Schema::getConnection()->getDoctrineSchemaManager();

        foreach (Config::get('migrations') as $tableName) {
            if (!Schema::hasTable($tableName)) continue;

            Schema::table($tableName, function($table) use($conn, $tableName) {
                array_map(function($key) use ($table) {
                    $table->dropForeign($key->getName());
                }, $conn->listTableForeignKeys($tableName));
            });

            Schema::drop($tableName);
        }
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
