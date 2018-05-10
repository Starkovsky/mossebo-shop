<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSocialProvidersTable extends Migration
{
    protected $tableName;

    public function __construct() {
        $this->tableName = Config::get('migrations.SocialProviders');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();

        echo "Create SocialProviders\r\n";

        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->increments('id');

            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on(Config::get('migrations.Users'))->onDelete('cascade');

            $table->string('provider_id');
            $table->string('provider')->index();
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