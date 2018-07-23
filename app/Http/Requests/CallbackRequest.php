<?php

namespace App\Http\Requests;

class CallbackRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'bail|required|trim|max:255',
            'phone' => 'bail|required|trim|max:255|phone'
        ];
    }
}
