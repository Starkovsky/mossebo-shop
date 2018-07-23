<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use SeoProxy;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        if ($query) {
            SeoProxy::setTitle(trans('search.title.phrase', ['phrase' => $query]));
        }
        else {
            SeoProxy::setTitle(trans('search.title.empty'));
        }

        return view('shop.pages.search');
    }
}
