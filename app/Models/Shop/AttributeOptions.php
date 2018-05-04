<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use App;

class AttributeOptions extends Model
{
    /**
     * Связанная с моделью таблица.
     *
     * @var string
     */
    protected $table = 'shop_attribute_options';

    public function i18n()
    {
        $locale = App::getLocale();
        return $this
            ->hasOne(AttributeOptionsI18n::class, 'option_id')
            ->where('language_code','=', $locale);
    }
}
