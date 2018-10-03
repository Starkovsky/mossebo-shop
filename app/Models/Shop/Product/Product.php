<?php

namespace App\Models\Shop\Product;

use Shop;
use App\Models\Media;
use App\Models\Review;
use App\Models\Shop\Badge\Badge;
use MosseboShopCore\Models\Shop\Product\Product as BaseProduct;
use MosseboShopCore\Contracts\Shop\Cart\CartProductData;
use App\Models\Shop\Category\Category;
use App\Models\Shop\Category\CategoryProduct;
use App\Models\Shop\Price\Price;
use App\Models\Shop\Style\Style;
use App\Models\Shop\Style\StyleProduct;
use App\Models\Shop\Room\Room;
use App\Models\Shop\Room\RoomProduct;
use App\Models\Shop\Attribute\Attribute;
use App\Models\Shop\Attribute\AttributeOption;
use App\Models\Shop\Supplier\Supplier;
use App\Support\Traits\Models\HasI18n;

class Product extends BaseProduct implements CartProductData
{
    use HasI18n;

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
        );
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

    public function previews()
    {
        return $this
            ->morphMany(Media::class, 'model')
            ->orderBy('order_column', 'asc');
    }

    public function currentPrice()
    {
        return $this
            ->morphOne(Price::class, 'item')
            ->where('currency_code', '=', Shop::getCurrentCurrencyCode())
            ->where('price_type_id','=', Shop::getCurrentPriceTypeId());
    }

    public function oldPrice()
    {
        return $this
            ->morphOne(Price::class, 'item')
            ->where('currency_code', '=', Shop::getCurrentCurrencyCode())
            ->where('price_type_id','=', '1');
    }

    public function salePrice()
    {
        return $this
            ->morphOne(Price::class, 'item')
            ->where('currency_code', '=', Shop::getCurrentCurrencyCode())
            ->where('price_type_id','=', '6');
    }

    public function relatedRelations()
    {
        return $this->hasMany(RelatedProduct::class, $this->relationFieldName);
    }

    public function related()
    {
        return $this->hasManyThrough(
            Product::class, RelatedProduct::class,
            $this->relationFieldName, 'id', 'id', 'related_id'
        );
    }

    public function badges()
    {
        return $this->morphMany(Badge::class, 'item');
    }

    public static function getCartItem($id, $options = [])
    {
        $productTable = (new static)->getTable();

        $query = self::enabled()
            ->where("{$productTable}.id", $id)
            ->with(
                'image',
                'i18n',
                'prices'
            );

        if (! empty($options)) {
            $optionsTable = config('tables.AttributeOptions');
            $productOptionsTable = config('tables.ProductAttributeOptions');

            $query->join("{$productOptionsTable}", function($join) use($productTable, $optionsTable, $productOptionsTable, $options) {
                $join->on("{$productOptionsTable}.product_id", '=', "{$productTable}.id")
                    ->join("{$optionsTable}", function($join) use($optionsTable, $productOptionsTable, $options) {
                        $join->on("{$optionsTable}.id", '=', "{$productOptionsTable}.option_id")
                            ->where("{$optionsTable}.enabled", true)
                            ->whereIn("{$optionsTable}.id", $options);
                    });
            });
        }

        return $query->first();
    }

    public function canBeShowed(): bool
    {
        if (! $this->enabled) {
            return false;
        }

        if ($this->relationIsEmpty('prices') && $this->relationIsEmpty('currentPrice')) {
            return false;
        }

        if ($this->relationIsEmpty('image') && $this->relationIsEmpty('images') && $this->relationIsEmpty('previews')) {
            return false;
        }

        if (isset($this['supplier_enabled'])) {
            if (! $this->supplier_enabled) {
                return false;
            }
        }
        else {
            if (!$this->supplier->enabled) {
                return false;
            }
        }

        return true;
    }

    /**
     * Возвращает актуальную цену товара
     *
     * @return mixed
     */
    public function getActualPrice()
    {
        if ($this->relationNotEmpty('salePrice') && Shop::sales()->productInSale($this)) {
            $price = $this->salePrice;
        }
        else {
            $price = $this->currentPrice;
        }

        return app()->makeWith(\MosseboShopCore\Contracts\Shop\Price::class, [
            'value' => $price->value,
            'currencyCode' => $price->currency_code
        ]);
    }

    public function show()
    {
        $this->disableSearchSyncing();

        $this->update([
            'showed' => $this->showed + 1
        ]);
    }

    public function getImage(): ?array
    {
        if ($this->relationIsEmpty('image')) {
            return null;
        }

        return json_decode($this->image->pathes, true);
    }

    public function getI18nTitles(): ?array
    {
        if ($this->relationIsEmpty('i18n')) {
            $this->i18n()->get();
        }

        return $this->i18n->reduce(function($carry, $item) {
            $carry[$item->language_code] = $item->title;

            return $carry;
        }, []);
    }

    public function getTitle($languageCode)
    {
        $titles = $this->getI18nTitles();

        if (! $titles || !isset($titles[$languageCode])) {
            return null;
        }

        return $titles[$languageCode];
    }

    public function getPrices(): ?array
    {
        if ($this->relationIsEmpty('prices')) {
            return null;
        }

        return $this->prices->map(function($item) {
            return [
                'currency_code' => $item->currency_code,
                'price_type_id' => $item->price_type_id,
                'value'         => $item->value,
            ];
        })->toArray();
    }

    public function getOptions(): array
    {
        if ($this->relationNotEmpty('attributeOptionRelations')) {
            return array_column($this->attributeOptionRelations, 'option_id');
        }

        if ($this->relationNotEmpty('attributeOptions')) {
            return array_column($this->attributeOptions, 'id');
        }

        return array_column($this->attributeOptionRelations()->get()->toArray(), 'option_id');
    }
}
