<?php

namespace App\Http\Requests\Checkout;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\User;

class PhoneRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // todo: Допилить форматирование номера
        $rule = Rule::unique((new User)->getTable());

        if ($user = \Auth::user()) {
            $rule->ignore($user->id);
        }

        return [
            'phone' => ['size:10', $rule]
        ];
    }
}
