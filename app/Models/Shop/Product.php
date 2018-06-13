<?php

namespace App\Models\Shop;

use App\Models\Media;
use MosseboShopCore\Models\Shop\Product as BaseProduct;

class Product extends BaseProduct
{
    public function prices()
    {
        return $this->morphMany(Price::class, 'item');
    }

    public function categoryRelations()
    {
        return $this->hasMany(CategoryProduct::class, $this->relationFieldName);
    }

    public function categories()
    {
        return $this->hasManyThrough(
            Category::class, CategoryProduct::class,
            $this->relationFieldName, 'id'
        );
    }

    public function attributes()
    {
        return $this->hasManyThrough(
            Attribute::class, ProductAttribute::class,
            $this->relationFieldName, 'id', 'id', 'attribute_id'
        );
    }

    public function attributeRelations()
    {
        return $this->hasMany(ProductAttribute::class, $this->relationFieldName);
    }

    public function attributeOptions()
    {
        return $this->hasManyThrough(
            AttributeOption::class, ProductAttributeOption::class,
            $this->relationFieldName, 'id', 'id', 'option_id'
        )->with('currentI18n');
    }

    public function attributeOptionRelations()
    {
        return $this->hasMany(ProductAttributeOption::class, $this->relationFieldName);
    }

    public function supplier()
    {
        return $this->hasOne(Supplier::class, 'id', 'supplier_id');
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

    public function currentPrice()
    {
        return $this
            ->hasOne(Price::class, 'item_id')
            ->where('item_type','=', 'product')
            ->where('price_type_id','=', '2');
    }

    public function oldPrice()
    {
        return $this
            ->hasOne(Price::class, 'item_id')
            ->where('item_type','=', 'product')
            ->where('price_type_id','=', '1');
    }

    public static function getCartItem($id, $options = [])
    {
        $productTable = (new static)->getTable();
        $optionsTable = (new AttributeOption())->getTable();
        $productOptionsTable = (new ProductAttributeOption)->getTable();

        $query = self::with(['image', 'prices', 'currentI18n'])
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

    public function canBeShowed()
    {
        return
            $this->enabled &&
            $this->currentPrice &&
            $this->currentI18n &&
            $this->image &&
            $this->supplier->enabled;
    }
}
