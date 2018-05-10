<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PriceTypesToI18n extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $types = \DB::table(Config::get('migrations.PriceTypes'))->get();
        $i18nTable = \DB::table(Config::get('migrations.PriceTypesI18n'));

        foreach ($types as $type) {
            $i18nTable->insert([
                'price_type_id' => $type->id,
                'language_code' => 'ru',
                'title' => $type->title,
                'description' => $type->description,
            ]);
        }

        Schema::table(Config::get('migrations.PriceTypes'), function(Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('title');
            $table->dropColumn('description');
        });
    }
}
