<?php

namespace App\Http\Controllers;

use App\Http\Requests\CallbackRequest;
use Illuminate\Http\Request;

class FormController extends Controller
{
    public function __construct()
    {
        $this->middleware('throttle:5,2');
    }

    public function callback(CallbackRequest $request)
    {
        return response()->json([
            'status' => 'success',
            'message' => trans('form.callback.success')
        ], 200);
    }

    public function review(CallbackRequest $request)
    {
        return response()->json([
            'status' => 'success',
            'message' => trans('form.review.success')
        ], 200);
    }
}
