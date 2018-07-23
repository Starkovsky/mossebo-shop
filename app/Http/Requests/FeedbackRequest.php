<?php

namespace App\Http\Requests;

class FeedbackRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'bail|required|trim|max:255',
            'phone' => 'bail|required|trim|max:255|phone',
            'message' => 'bail|required|trim|max:2048',
        ];
    }
}
