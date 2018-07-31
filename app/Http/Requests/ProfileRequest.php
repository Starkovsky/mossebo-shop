<?php

namespace App\Http\Requests;

use Auth;

class ProfileRequest extends FormRequest
{
    public function rules()
    {
        $user = Auth::user();

        return [
            'first_name' => 'bail|required|string|max:255',
            'last_name'  => 'bail|required|string|max:255',
            'phone'      => 'bail|required|string|max:255|unique:users,phone,' . $user->id,
            'email'      => 'bail|required|string|email|between:6,255|unique:users,email,' . $user->id,
            'address'    => 'nullable|max:510',
            'city'       => 'nullable|max:255',
            'post_code'  => 'nullable|max:255',
        ];
    }
}
