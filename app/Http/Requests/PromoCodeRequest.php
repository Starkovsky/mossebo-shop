<?php

namespace App\Http\Requests;

use App\Cart\CartProxy;
use App\Cart\Promo\PromoCode;

class PromoCodeRequest extends FormRequest
{
    protected $promoCode;

    public function rules()
    {
        return [
            'promo_code' => [
                'bail', 'required',
                function($attribute, $value, $fail) {
                    return $this->checkPromo($fail);
                }
            ]
        ];
    }

    protected function prepareForValidation()
    {
        $this->promoCode = new PromoCode($this->input('promo_code'));
    }

    protected function checkPromo($fail)
    {
        if ($this->promoCode->notExist()) {
            return $fail('Промокод введен некорректно.');
        }

        if ($this->promoCode->notActual()) {
            return $fail('Действие промокода истекло.');
        }

        $validator = $this->promoCode->validate(CartProxy::getInstance());

        if ($validator->hasError()) {
            return $fail($validator->getErrorMessage());
        }
    }
}
