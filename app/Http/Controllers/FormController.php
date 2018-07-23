<?php

namespace App\Http\Controllers;

use App\Http\Requests\CallbackRequest;
use App\Http\Requests\FeedbackRequest;
use App\Http\Requests\OneClickRequest;
use App\Mail\OneClick;
use Illuminate\Support\Facades\Mail;
use App\Mail\Callback;
use App\Mail\Feedback;

class FormController extends Controller
{
    public function __construct()
    {
        $this->middleware('throttle:5,2');
    }

    public function callback(CallbackRequest $request)
    {
        Mail::to(config('mail.to.address'), config('mail.to.name'))
            ->queue(new Callback($request->all()));

        return response()->json([
            'status' => 'success',
            'message' => trans('form.callback.success')
        ], 200);
    }

    public function feedback(FeedbackRequest $request)
    {
        Mail::to(config('mail.to.address'), config('mail.to.name'))
            ->queue(new Feedback($request->all()));

        return response()->json([
            'status' => 'success',
            'message' => trans('form.feedback.success')
        ], 200);
    }

    public function oneClick(OneClickRequest $request)
    {
        Mail::to(config('mail.to.address'), config('mail.to.name'))
            ->queue(new OneClick($request->all()));

        return response()->json([
            'status' => 'success',
            'message' => trans('form.one-click.success')
        ], 200);
    }
}
