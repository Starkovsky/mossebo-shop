<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use MosseboShopCore\Models\User as BaseUser;
use App\Support\Traits\Models\UserNotifications;

use Cog\Contracts\Love\Liker\Models\Liker as LikerContract;
use Cog\Laravel\Love\Liker\Models\Traits\Liker;

use App\Models\Shop\Order;
use App\Models\Shop\Promo\PromoUse;


class User extends BaseUser implements LikerContract
{
    use Liker, Notifiable, UserNotifications;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'phone', 'email', 'address', 'password', 'city', 'post_code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

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
}
