<?php

namespace App\Models;

use MosseboShopCore\Models\Review as BaseReview;

class Review extends BaseReview
{
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
