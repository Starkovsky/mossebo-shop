<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminLogTable extends Migration
{
    protected $tableName;

    public function __construct() {
        $this->tableName = Config::get('migrations.AdminLog');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();

        echo "Create AdminLog\r\n";

        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = "InnoDB";

            $table->increments('id');

            $table->integer('admin_id')->unsigned()->index();
            $table->foreign('admin_id')->references('id')->on(Config::get('migrations.Admins'));

            $table->string('type');
            $table->text('message');
            $table->timestamp('created_at');
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
