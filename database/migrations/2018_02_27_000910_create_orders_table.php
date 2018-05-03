<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    protected $tableName;

    public function __construct() {
        $this->tableName = Config::get('migrations.Orders');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();

        echo "Create Orders\r\n";

        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->increments('id');

            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on(Config::get('migrations.Users'))->onDelete('cascade');

            $table->char('language_code', 2);
            $table->foreign('language_code')->references('code')->on(Config::get('migrations.Languages'));

            $table->integer('order_status_id')->unsigned()->index();
            $table->foreign('order_status_id')->references('id')->on(Config::get('migrations.OrderStatuses'));

            $table->string('name'); // Имя пользователя, указанное при оформлении заказа
            $table->text('address'); // Адрес пользователя, указанный при оформлении заказа
            $table->string('email'); // E-mail пользователя, указанный при оформлении заказа
            $table->string('phone', 64); // Телефон пользователя, указанный при оформлении заказа

            $table->integer('is_one_click')->unsigned()->index()->default(0);

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
