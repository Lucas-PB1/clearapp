<?php

namespace App\Http\Traits;

use App\Models\CMS\Archives;

trait HasGaleria
{
    public function galeria()
    {
        return $this->hasMany(Archives::class, 'reference_id', 'id')
            ->where('highlight', "!=", true)
            ->orderBy('id', 'DESC');
    }
}
