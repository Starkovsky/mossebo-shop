<?php

namespace App\Http\Controllers\Shop;

use Auth;
use SeoProxy;
use App\Models\Shop\Product;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use App\Http\Resources\ReviewResource;

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
            'attributeRelations',
            'attributeOptions',
            'supplier'
        )
            ->where('enabled','=',true)
            ->findOrFail($id);

        $attributesIds = array_column($product->attributeRelations->toArray(), 'attribute_id');
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
            $product->show();

            SeoProxy::setMetaFromI18nModel($product);
            SeoProxy::setImageFromModel($product, 'oneHalf');

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

    public function reviews(Product $product)
    {
        $user = Auth::user();

        $reviews = $product->reviews()
            ->with('user')
            ->where('enabled', 1)
            ->where('language_code', app()->getLocale())
            ->where(function($query) use($user) {
                $query->where('confirmed', 1);

                if ($user) {
                    $query->orWhere(function ($query) use($user) {
                        $query->where('confirmed', 0)->where('user_id', $user->id);
                    });
                }
            })
            ->get();

        return response()->json([
            'status' => 'success',
            'reviews' => ReviewResource::collection($reviews)
        ]);
    }
}
