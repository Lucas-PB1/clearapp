<?php

namespace App\Models\CMS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RedesSociais extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'redes-sociais';

    protected $fillable = [
        
        'nome',
        'icone',
        'link',

    ];
}