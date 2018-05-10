<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttributeOptionsI18nTable extends Migration
{
    protected $tableName;

    public function __construct() {
        $this->tableName = Config::get('migrations.AttributeOptionsI18n');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();

        echo "Create AttributeOptionsI18\r\n";

        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->integer('option_id')->unsigned();
            $table->foreign('option_id')->references('id')->on(Config::get('migrations.AttributeOptions'))->onDelete('cascade');

            $table->char('language_code', 2);
            $table->foreign('language_code')->references('code')->on(Config::get('migrations.Languages'));

            $table->string('value');

            $table->primary(['option_id', 'language_code'])->index();
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
