<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderProductsTable extends Migration
{
    protected $tableName;

    public function __construct() {
        $this->tableName = Config::get('migrations.OrderProducts');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();

        echo "Create OrderProducts\r\n";

        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->integer('order_id')->unsigned()->index();
            $table->foreign('order_id')->references('id')->on(Config::get('migrations.Orders'))->onDelete('cascade');

            $table->integer('product_id')->unsigned()->index();
            $table->foreign('product_id')->references('id')->on(Config::get('migrations.Products'));

            $table->text('product_params');

            $table->string('title');
            $table->text('description');
            $table->integer('price')->unsigned()->index();
            $table->char('currency_code', 3);
            $table->foreign('currency_code')->references('code')->on(Config::get('migrations.Currencies'));
            $table->integer('quantity')->unsigned();
            $table->string('image_path')->nullable();

            $table->primary(['order_id', 'product_id']);
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
