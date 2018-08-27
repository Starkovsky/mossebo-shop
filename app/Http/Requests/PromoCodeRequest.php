<?php

namespace App\Http\Requests;

use Cart;
use App\Shop\Cart\Promo\PromoCode;
use App\Http\Resources\PromoCodeResource;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

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

        $validator = $this->promoCode->validate(Cart::get());

        if ($validator->hasError()) {
            return $fail($validator->getErrorMessage());
        }
    }

    protected function failedValidation(Validator $validator)
    {
        if ($validator->fails()) {
            $errors = [];

            foreach ($validator->errors()->messages() as $fieldName => $messages) {
                $errors[$fieldName] = $messages[0];
            }
        }

        $responseData = [
            'status' => 'error',
            'errors' => $this->collectErrorMessages($validator),
        ];

        if (! $this->promoCode->notExist()) {
            $responseData['promoCode'] = new PromoCodeResource($this->promoCode);
        }

        throw new HttpResponseException(response()->json($responseData, 422));
    }
}
