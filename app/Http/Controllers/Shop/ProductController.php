<?php

namespace App\Http\Controllers\Shop;

use App\Models\Shop\Product;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;

class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Выводит главную страницу
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $product = Product::with(
            'currentI18n',
            'images',
            'currentPrice',
            'oldPrice',
            'productAttributes',
            'attributeOptions',
            'supplier'
        )
            ->where('enabled','=',true)
            ->findOrFail($id);

        $attributesIds = array_column($product->productAttributes->toArray(), 'attribute_id');
        $optionsIds = array_column($product->attributeOptions->toArray(), 'id');

        $attributes = \Attributes::enabled(['currentI18n'])
            ->whereIn('id', $attributesIds);

        $carry = [
            'all' => new Collection(),
            'selectable' => new Collection(),
        ];

        $attributes->reduce(function($carry, $attribute) use ($optionsIds) {
            $attribute->setRelation('options', $attribute->options->whereIn('id', $optionsIds));

            $count = $attribute->options->count();

            if ($count > 0) {
                if ($count > 1 && $attribute->selectable) {
                    $carry['selectable']->push([
                        'id' => $attribute->id,
                        'title' => $attribute->currentI18n->title,
                        'options' => $attribute->options->reduce(function ($carry, $item) {
                            $carry[] = [
                                'id' => $item->id,
                                'title' => $item->currentI18n->value
                            ];

                            return $carry;
                        }, []),
                        'need_to_select' => true
                    ]);
                }
                else {
                    $carry['all']->push($attribute);
                }
            }

            return $carry;
        }, $carry);


        // Проверка доступности товаров поставщика
        if ($product->canBeShowed()) {
            return view('shop.pages.product', [
                'product' => $product,
                'attributes' => $carry['all'],
                'selectable' => json_encode($carry['selectable'], JSON_UNESCAPED_UNICODE)
            ]);
        }
        else {
            return abort(404);
        }
    }
}
