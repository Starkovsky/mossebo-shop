<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use MosseboShopCore\Models\User as BaseUser;
use App\Support\Traits\Models\UserNotifications;

use Cog\Contracts\Love\Liker\Models\Liker as LikerContract;
use Cog\Laravel\Love\Liker\Models\Traits\Liker;

use App\Models\Shop\Order\Order;
use App\Models\Shop\Promo\PromoUse;
use App\Models\Shop\Cart\Cart;


class User extends BaseUser implements LikerContract
{
    use Liker, Notifiable, UserNotifications;

    public function socialProviders()
    {
        return $this->hasMany(SocialProvider::class);
    }

    public function getFullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function orders()
    {
        return $this->hasMany(Order::class, $this->relationFieldName, 'id');
    }

    public function promoCodeUses()
    {
        return $this->hasMany(PromoUse::class, $this->relationFieldName, 'id');
    }

    public function cart()
    {
        return $this->hasOne(Cart::class, $this->relationFieldName, 'id');
    }

    public function getCart()
    {
        $cart = $this->cart()
            ->with([
                'cartProducts' => function($query) {
                    $query->with('options');
                },
                'promoCode'
            ])
            ->first();

        if ($cart) {
            $cart->products = $cart->cartProducts;
            $cart->promoCode = $cart->promoCode->first();
        }

        return $cart;
    }
}
