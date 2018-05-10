<?php

namespace App\Models;

use App\Models\Shop\Currency;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    /**
     * Связанная с моделью таблица.
     *
     * @var string
     */
    protected $table = 'languages';

    public function currency()
    {
        return $this
            ->hasOne(Currency::class, 'code','currency_code');
    }
}
