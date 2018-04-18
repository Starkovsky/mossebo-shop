<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use App;

class Product extends Model
{
    /**
     * Связанная с моделью таблица.
     *
     * @var string
     */
    protected $table = 'shop_products';


    public function languages()
    {
        return $this
            ->belongsToMany(
                Language::class,
                'shop_languages',
                'product_id',
                'language_id'
            );
    }

    public function i18n()
    {
        $locale = App::getLocale();
        return $this
            ->hasOne(ProductI18n::class, 'product_id')
            ->where('language_code','=', $locale);
    }

    public function supplier()
    {
        return $this
            ->hasOne(Supplier::class, 'id','supplier_id');
    }

    public function prices()
    {
        return $this
            ->morphMany(Price::class, 'item');
    }

}
