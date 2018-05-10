<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLanguagesTable extends Migration
{
    protected $tableName;

    public function __construct() {
        $this->tableName = Config::get('migrations.Languages');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();

        echo "Create Languages\r\n";

        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->char('code', 2)->primary()->index();
            $table->string('name');
            $table->string('image')->nullable();

            $table->char('currency_code', 3)->nullable();
            $table->foreign('currency_code')->references('code')->on(Config::get('migrations.Currencies'))->onDelete('set null');

            $table->boolean('default')->default(0);
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