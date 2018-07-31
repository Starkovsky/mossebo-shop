<?php

namespace App\Http\Controllers\Cabinet;

use Auth;
use App\Http\Controllers\Controller;

class CabinetController extends Controller
{
    public function index()
    {
        return view('shop.pages.cabinet');
    }
}
