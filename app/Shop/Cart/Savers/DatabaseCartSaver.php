<?php

namespace App\Shop\Cart\Savers;

use MosseboShopCore\Shop\Cart\Savers\AbstractCartSaver;
use DB;
use App\Models\Shop\Cart\Cart;
use App\Models\Shop\Cart\CartProduct;
use App\Models\Shop\Cart\CartProductAttributeOption;
use App\Models\Shop\Cart\CartPromoCode;
use MosseboShopCore\Contracts\Shop\Cart\Cart as CartInterface;

class DatabaseCartSaver extends AbstractCartSaver
{
    protected $model = null;

    public function __construct(CartInterface $cart)
    {
        parent::__construct($cart);

        $this->model = Cart::where('user_id', $this->getCart()->getCustomer()->id)->first();
    }

    public function save()
    {
        if ($this->getCart()->isEmpty()) {
            $this->model->delete();
        }

        DB::transaction(function() {
            $this->saveCart();
            $this->saveProducts();
            $this->savePromo();
        });
    }

    protected function saveCart()
    {
        $data = [
            'currency_code' => $this->getCart()->getCurrencyCode(),
            'created_at'    => $this->getCart()->getCreatedAt(),
            'updated_at'    => $this->getCart()->getUpdatedAt(),
        ];

        if (is_null($this->model)) {
            $data['user_id'] = $this->getCart()->getCustomer()->id;

            $this->model = new Cart($data);
        }
        else {
            $this->model->cartProducts()->delete();
            $this->model->promoCodeRelation()->delete();

            $this->model->fill($data);
        }

        $this->model->save();
    }

    protected function saveProducts()
    {
        foreach ($this->getCart()->getProducts() as $cartProduct) {
            $dbCartProduct = new CartProduct([
                'product_id' => $cartProduct->getProductId(),
                'quantity'   => $cartProduct->getQuantity(),
                'params'     => json_encode([
                    'image'  => $cartProduct->getImage(),
                    'prices' => $cartProduct->getPrices(),
                    'titles' => $cartProduct->getI18nTitles(),
                ], JSON_UNESCAPED_UNICODE)
            ]);

            $this->model->cartProducts()->save($dbCartProduct);

            foreach ($cartProduct->getOptions() as $optionId) {
                dd($optionId);
                $dbCartProduct->save(new CartProductAttributeOption([
                    'option_id' => $optionId
                ]));
            }
        }
    }

    protected function savePromo()
    {
        if ($promoCode = $this->getCart()->getPromoCode()) {
            $this->model->promoCodeRelation()->save(new CartPromoCode([
                'promo_code_id' => $promoCode->getId()
            ]));
        }
    }
}
