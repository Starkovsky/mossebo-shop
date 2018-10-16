<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Review;
use App\Models\Shop\Product\Product;
use App\Http\Requests\ReviewRequest;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    protected $user;

    public function product(ReviewRequest $request, Product $product)
    {
        if (! $this->setUser()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Войдите, чтобы оставить отзыв.'
            ], 401);
        }

        $locale = app()->getLocale();

        $unconfirmedReview = $product->reviews()
            ->where('user_id', $this->user->id)
            ->where('language_code', $locale)
            ->where('confirmed', 0)
            ->where('enabled', 1)
            ->first();

        if ($unconfirmedReview) {
            //todo: Сформулировать ответ правильно
            return response()->json([
                'status' => 'error',
                'message' => 'Вы уже оставили отзыв для этого товара. Пожалуйста дождитесь прохождения модерации.'
            ], 409);
        }

        $product->reviews()->create(array_merge($this->credentials($request), [
            'language_code' => $locale,
            'user_id'       => $this->user->id,
            'confirmed'     => 0
        ]));

        return response()->json([
            'status' => 'success',
            'message' => 'Спасибо за ваш отзыв! Он появится на сайте после прохождения модерации.'
        ], 200);
    }

    public function edit(ReviewRequest $request, Review $review)
    {
        if (! $this->setUser()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Войдите, чтобы изменить отзыв.'
            ], 401);
        }

        if ($this->wrongUser($review)) {
            return response()->json([
                'status' => 'error'
            ], 403);
        }

        $review->fill(array_merge(
            $this->credentials($request),
            ['confirmed' => false]
        ))->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Изменения сохранены. Отзыв появится на сайте после прохождения модерации.'
        ], 200);
    }

    public function delete(Review $review)
    {
        if (! $this->setUser()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Войдите, чтобы удалить отзыв.'
            ], 401);
        }

        if ($this->wrongUser($review)) {
            return response()->json([
                'status' => 'error'
            ], 403);
        }

        $review->fill([
            'enabled' => false,
        ])->save();

        return response()->json([
            'status' => 'success',
        ], 200);
    }

    protected function setUser()
    {
        return $this->user = Auth::user();
    }

    protected function wrongUser(Review $review)
    {
        return $review->user_id !== $this->user->id;
    }

    protected function credentials(Request $request)
    {
        return $request->only('rate', 'advantages', 'disadvantages', 'comment', 'usage_time');
    }
}
