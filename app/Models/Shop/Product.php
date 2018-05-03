<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use App;
use App\Models\Media;

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

    public function images()
    {
        return $this
            ->hasMany(Media::class, 'model_id')
            ->where('model_type','=', 'product')
            ->orderBy('order_column', 'asc');
    }

    public function current_price()
    {
        return $this
            ->hasOne(Price::class, 'item_id')
            ->where('item_type','=', 'product')
            ->where('price_type_id','=', '2');
    }

    public function old_price()
    {
        return $this
            ->hasOne(Price::class, 'item_id')
            ->where('item_type','=', 'product')
            ->where('price_type_id','=', '1');
    }

}
