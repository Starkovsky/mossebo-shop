<?php

namespace App\Http\Controllers;

use App\Http\Resources\LikeResource;
use Auth;
use App\Models\Review;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function review(Request $request, Review $review)
    {
        $user = Auth::user();

        // todo: Перевести
        if (! $user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Войдите, чтобы поставить отметку.'
            ], 401);
        }

        if ($review->user)

        $action = $request->input('action');
        $value = $request->input('value');

        if ($action === 'liked') {
            if ($value) {
                $user->like($review);
            }
            else {
                $user->unlike($review);
            }
        }

        if ($action === 'disliked') {
            if ($value) {
                $user->dislike($review);
            }
            else {
                $user->undislike($review);
            }
        }

        return response()->json([
            'status' => 'success',
            'likes' => new LikeResource($review)
        ], 200);
    }
}
