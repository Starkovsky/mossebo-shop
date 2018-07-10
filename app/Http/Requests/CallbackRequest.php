<?php

namespace App\Http\Requests;

class CallbackRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'bail|required|trim|max:255',
            'phone' => 'bail|required|trim|max:255|phone'
        ];
    }
}
