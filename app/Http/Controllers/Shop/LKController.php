<?php

namespace App\Http\Controllers\Shop;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LKController extends Controller
{
    //
    public function orders()
    {
        return view('shop.lk.orders');
    }
    //
    public function profile()
    {
        return view('shop.lk.profile');
    }
    //
    public function reviews()
    {
        return view('shop.lk.reviews');
    }
}
