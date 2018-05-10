<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePricesTable extends Migration
{
    protected $tableName;

    public function __construct() {
        $this->tableName = Config::get('migrations.Prices');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();

        echo "Create Prices\r\n";

        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->bigIncrements('id');
            $table->string('item_type');
            $table->integer('item_id')->unsigned();

            $table->char('currency_code', 3);
            $table->foreign('currency_code')->references('code')->on(Config::get('migrations.Currencies'))->onDelete('cascade');

            $table->integer('price_type_id')->unsigned();
            $table->foreign('price_type_id')->references('id')->on(Config::get('migrations.PriceTypes'))->onDelete('cascade');

            $table->integer('value')->unsigned();

            $table->timestamps();

            $table->unique(['item_type', 'item_id', 'currency_code', 'price_type_id']);

            $table->index(['item_type', 'item_id']);
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