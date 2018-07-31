<?php

namespace App\Models\Shop;

use App\Models\Media;
use App\Models\Review;
use Laravel\Scout\Searchable;
use MosseboShopCore\Models\Shop\Product as BaseProduct;

class Product extends BaseProduct
{
    use Searchable;

    protected $fillable = [
        'showed'
    ];

    public function reviews()
    {
        return $this->morphMany(Review::class, 'item');
    }

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
            $this->relationFieldName, 'id', 'id', 'category_id'
        );
    }

    public function styleRelations()
    {
        return $this->hasMany(StyleProduct::class, $this->relationFieldName);
    }

    public function styles()
    {
        return $this->hasManyThrough(
            Style::class, StyleProduct::class,
            $this->relationFieldName, 'id', 'id', 'style_id'
        );
    }

    public function roomRelations()
    {
        return $this->hasMany(RoomProduct::class, $this->relationFieldName);
    }

    public function rooms()
    {
        return $this->hasManyThrough(
            Room::class, RoomProduct::class,
            $this->relationFieldName, 'id', 'id', 'room_id'
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
            ->morphOne(Media::class, 'model')
            ->orderBy('order_column', 'asc');
    }

    public function images()
    {
        return $this
            ->morphMany(Media::class, 'model')
            ->orderBy('order_column', 'asc');
    }

    public function currentPrice()
    {
        return $this
            ->morphOne(Price::class, 'item')
            ->where('price_type_id','=', '2');
    }

    public function oldPrice()
    {
        return $this
            ->morphOne(Price::class, 'item')
            ->where('price_type_id','=', '1');
    }

    public function similarRelations()
    {
        return $this->hasMany(SimilarProduct::class, $this->relationFieldName);
    }

    public function similar()
    {
        return $this->hasManyThrough(
            Product::class, SimilarProduct::class,
            $this->relationFieldName, 'id', 'id', 'similar_id'
        );
    }

    public static function getCartItem($id, $options = [])
    {
        $productTable = (new static)->getTable();

        $query = self::enabled()
            ->select("{$productTable}.*")
            ->where("{$productTable}.id", $id);

        if (! empty($options)) {
            $optionsTable = config('tables.AttributeOptions');
            $productOptionsTable = config('tables.ProductAttributeOptions');

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
            ($this->image || $this->images) &&
            $this->supplier->enabled;
    }

    public function show()
    {
        $this->update([
            'showed' => $this->showed + 1
        ]);
    }
}
