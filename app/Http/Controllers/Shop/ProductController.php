<?php

namespace App\Http\Controllers\Shop;

use Illuminate\Support\Collection;

use Shop;
use Auth;
use SeoProxy;
use BadgeTypes;
use App\Models\Shop\Product\Product;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReviewResource;
use App\Http\Resources\Product\ProductResource;
use App\Http\Controllers\ContentController;

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
        $product = Product::enabled()
            ->with(
                'badges',
                'images',
                'currentPrice',
                'salePrice',
                'oldPrice',
                'attributeRelations',
                'attributeOptions',
                'reviews'
            )
            ->findOrFail($id);

        if (! $product->canBeShowed()) {
            return abort(404);
        }

        $attributesIds = array_column($product->attributeRelations->toArray(), 'attribute_id');
        $optionsIds = array_column($product->attributeOptions->toArray(), 'id');

        $attributes = \Attributes::whereIn('id', $attributesIds);

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
                        'title' => $attribute->title,
                        'options' => $attribute->options->reduce(function ($carry, $item) {
                            $carry[] = [
                                'id' => $item->id,
                                'title' => $item->value
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
        $product->show();

        SeoProxy::setMetaFromModel($product);
        SeoProxy::setImageFromModel($product, 'oneHalf');

        $data = [
            'product' => new ProductResource($product),
            'attributes' => $carry['all'],
            'selectable' => json_encode($carry['selectable'], JSON_UNESCAPED_UNICODE)
        ];

        $this->connectContent($data);

        return view('shop.pages.product', $data);
    }

    protected function connectContent(& $data)
    {
        // todo: доделать при изменении системы контента
        foreach (['delivery', 'pay', 'garant'] as $item) {
            $data[$item] = ContentController::getHelpContent($item);
        }
    }

    public function reviews(Product $product)
    {
        $user = Auth::user();

        $reviews = $product->reviews()
            ->with('user', 'likesCounter', 'dislikesCounter', 'likes', 'dislikes')
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
