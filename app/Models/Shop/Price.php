<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    /**
     * Связанная с моделью таблица.
     *
     * @var string
     */
    protected $table = 'shop_prices';

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_code', 'code');
    }

    public function getCurrency()
    {
        return $this->currency()->first();
    }

    public function getFormatted()
    {
        extract($this->getCurrency()->toArray(), EXTR_OVERWRITE);

        $price = number_format(
            $this->getValue(),
            $precision,
            $decimal_separator,
            $thousand_separator
        );

        $price = str_replace(('.' . str_pad('', $precision, '0')), '', $price);

        if ($swap_currency_symbol) {
            $price = "$price $symbol";
        }
        else {
            $price = "$symbol $price";
        }

        return $price;
    }

    public function getValue()
    {
        return $this->value / $this->getDivider();
    }

    /**
     * @return integer
     */
    public function getDivider()
    {
        return pow(10, $this->getCurrency()['precision']);
    }
}
