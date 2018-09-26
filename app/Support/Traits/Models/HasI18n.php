<?php

namespace App\Support\Traits\Models;

trait HasI18n
{
    public function newQuery()
    {
        return parent::newQuery()->localized();
    }
}
