<?php

namespace App\Http\Controllers\Shop;

use Illuminate\Support\Collection;

use Auth;
use SeoProxy;
use BadgeTypes;
use App\Models\Shop\Product;
use App\Http\Controllers\Controller;
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
            'badges',
            'images',
            'currentPrice',
            'oldPrice',
            'attributeRelations',
            'attributeOptions',
            'supplier'
        )
            ->where('enabled','=',true)
            ->findOrFail($id);

        if (! $product->canBeShowed()) {
            return abort(404);
        }

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

        $badgeTypes = BadgeTypes::getCollection('currentI18n');

        $badges = $product->badges->reduce(function($acc, $item) use($badgeTypes) {
            $badge = $badgeTypes->where('id', $item->badge_type_id)->first();

            if ($badge) {
                $acc->push($badge);
            }

            return $acc;
        }, new Collection);

        // Проверка доступности товаров поставщика

        $product->show();

        SeoProxy::setMetaFromI18nModel($product);
        SeoProxy::setImageFromModel($product, 'oneHalf');

        return view('shop.pages.product', [
            'product' => $product,
            'badges'  => $badges,
            'attributes' => $carry['all'],
            'selectable' => json_encode($carry['selectable'], JSON_UNESCAPED_UNICODE)
        ]);
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
