<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConfigController extends Controller
{
    public function index()
    {
        $lang = \App\Models\Language::with('currency')->first();

        $config = [
            'language' => [
                'code' => $lang->code
            ],
            'currency' => [
                'symbol' => $lang->currency->symbol,
                'swap' => $lang->currency->swap_currency_symbol
            ],
        ];

        $this->__connectTranslates($config);

        return json_encode($config, JSON_UNESCAPED_UNICODE);
    }

    protected function __connectTranslates(& $config)
    {
        $config['translates'] = \Lang::get('js');
    }
}
