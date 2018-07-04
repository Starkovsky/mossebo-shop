<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use MosseboShopCore\Models\User as BaseUser;
use App\Support\Traits\Models\UserNotifications;

class User extends BaseUser
{
    use Notifiable, UserNotifications;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'phone', 'email', 'address', 'password',
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
        return $this->hasOne(SocialProvider::class);
    }

    public function getFullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
