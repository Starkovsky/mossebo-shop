<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurrenciesTable extends Migration
{
    protected $tableName;

    public function __construct() {
        $this->tableName = Config::get('migrations.Currencies');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();

        echo "Create Currencies\r\n";

        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->char('code', 3)->primary()->index();
            $table->string('name');
            $table->string('symbol');
            $table->tinyInteger('precision');
            $table->string('thousand_separator', 64);
            $table->string('decimal_separator', 64);
            $table->boolean('swap_currency_symbol')->default(false);
            $table->boolean('enabled')->default(0);
            $table->integer('position')->unsigned()->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->tableName);
    }
}
