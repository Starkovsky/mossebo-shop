<?php

namespace App\Http\Controllers\Cabinet;

use Auth;
use App\Models\Review;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReviewResource;

class ReviewController extends Controller
{
    public function index()
    {
        return response()->json([
            'reviews' => ReviewResource::collection(
                Review::enabled()
                    ->where('user_id', Auth::user()->id)
                    ->with(['item'])
                    ->get()
            )
        ], 200);
    }
}
