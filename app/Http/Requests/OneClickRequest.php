<?php

namespace App\Http\Requests;

class OneClickRequest extends FormRequest
{
    public function rules()
    {
        return [
            'phone' => 'bail|required|trim|max:255|phone',
        ];
    }
}
