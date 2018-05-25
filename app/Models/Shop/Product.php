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

    public function image()
    {
        return $this
            ->hasOne(Media::class, 'model_id')
            ->where('model_type','=', 'product')
            ->orderBy('order_column', 'asc');
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

    public function prices()
    {
        return $this->morphMany(Price::class, 'item');
    }

    public function attributes()
    {
        return $this
            ->belongsToMany(
                Attribute::class,
                'shop_product_attributes',
                'product_id',
                'attribute_id'
            )
            ->with('i18n');
    }

    public function attribute_options()
    {
        return $this
            ->belongsToMany(
                AttributeOption::class,
                'shop_product_attribute_options',
                'product_id',
                'option_id'
            )
            ->with('i18n');
    }

    public function productAttributeOptions()
    {
        return $this->hasMany(ProductAttributeOption::class, 'product_id');
    }

    public static function getCartItem($id, $options = [])
    {
        $productTable = (new static)->getTable();
        $optionsTable = (new AttributeOption())->getTable();
        $productOptionsTable = (new ProductAttributeOption)->getTable();

        $query = self::with(['image', 'prices', 'i18n'])
            ->select("{$productTable}.*")
            ->where("{$productTable}.enabled", true)
            ->where("{$productTable}.id", $id);

        if (! empty($options)) {
            $query->join("{$productOptionsTable}", "{$productOptionsTable}.product_id", '=', "{$productTable}.id")
                ->join("{$optionsTable}", "{$optionsTable}.id", '=', "{$productOptionsTable}.option_id")
                ->where("{$optionsTable}.enabled", true)
                ->whereIn("{$optionsTable}.id", $options)
                ->groupBy("{$productTable}.id");
        }

        return $query->first();
    }
}
