<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use App;

class Attribute extends Model
{
    /**
     * Связанная с моделью таблица.
     *
     * @var string
     */
    protected $table = 'shop_attributes';

    public function i18n()
    {
        $locale = App::getLocale();

        return $this
            ->hasOne(AttributeI18n::class, 'attribute_id')
            ->where('language_code','=', $locale);
    }

    public function options()
    {
        return $this
            ->hasMany(AttributeOption::class, 'attribute_id')
            ->with('i18n');
    }
}
