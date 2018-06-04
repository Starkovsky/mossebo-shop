<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use MosseboShopCore\Models\User as BaseUser;

class User extends BaseUser
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'last_name', 'phone', 'email', 'address', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function socialProvider()
    {
        return $this->hasOne(SocialAccount::class);
    }

}
