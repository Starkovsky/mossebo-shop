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

    public function products()
    {
        return $this
            ->belongsToMany(
                Product::class,
                'shop_category_products',
                'category_id',
                'product_id'
            )
            ->where('enabled','=',true)
            ->orderBy('id', 'desc');
    }
}
