<?php

namespace App\Models\Shop\Interior;

use MosseboShopCore\Models\Shop\Interior\Interior as BaseInterior;
use App\Models\Shop\Room\Room;
use App\Models\Shop\Style\Style;
use App\Support\Traits\Models\HasI18n;

class Interior extends BaseInterior
{
    use HasI18n;

    public function points()
    {
        return $this->hasMany(InteriorPoint::class, $this->relationFieldName, 'id');
    }

    public function styleRelations()
    {
        return $this->hasMany(InteriorStyle::class, $this->relationFieldName);
    }

    public function styles()
    {
        return $this->hasManyThrough(
            Style::class, InteriorStyle::class,
            $this->relationFieldName, 'id', 'id', 'style_id'
        );
    }

    public function roomRelations()
    {
        return $this->hasMany(InteriorRoom::class, $this->relationFieldName);
    }

    public function rooms()
    {
        return $this->hasManyThrough(
            Room::class, InteriorRoom::class,
            $this->relationFieldName, 'id', 'id', 'room_id'
        );
    }
}
