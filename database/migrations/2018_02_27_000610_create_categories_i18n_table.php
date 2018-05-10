<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesI18nTable extends Migration
{
    protected $tableName;

    public function __construct() {
        $this->tableName = Config::get('migrations.CategoriesI18n');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();

        echo "Create CategoriesI18n\r\n";

        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on(Config::get('migrations.Categories'))->onDelete('cascade');

            $table->char('language_code', 2);
            $table->foreign('language_code')->references('code')->on(Config::get('migrations.Languages'));

            $table->string('title');
            $table->text('description')->nullable();

            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();

            $table->primary(['category_id', 'language_code'])->index();
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