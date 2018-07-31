<?php

namespace App\Http\Requests;

use Auth;
use Hash;
use App\Models\User;

class PasswordRequest extends FormRequest
{
    public function rules()
    {
        return [
            'password' => [
                'bail', 'required', 'string','min:6',

                function($attribute, $value, $fail) {
                    $user = Auth::user()->fresh();

                    if (! Hash::check($value, $user->password)) {
                        return $fail(trans("validation.password"));
                    }
                }
            ],
            'password_new' => 'bail|required|string|min:6|confirmed',
        ];
    }
}
