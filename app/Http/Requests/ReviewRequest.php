<?php

namespace App\Http\Requests;

class ReviewRequest extends FormRequest
{
    public function rules()
    {
        return [
            'rate' => 'bail|required|between:1,5',
            'advantages' => 'max:512|nullable',
            'disadvantages' => 'max:512|nullable',
            'comment' => 'bail|required|max:2048',
            'usage_time' => 'in:month,half-year,year|nullable'
        ];
    }
}
