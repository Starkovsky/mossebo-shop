<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use App;

class Category extends Model
{
    use NodeTrait;

    /**
     * Связанная с моделью таблица.
     *
     * @var string
     */
    protected $table = 'shop_categories';


    public function i18n()
    {
        $locale = App::getLocale();
        return $this
            ->hasOne(CategoryI18n::class, 'category_id')
            ->where('language_code','=', $locale);
    }
}
