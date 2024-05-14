<?php

namespace App\Models\CMS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Configurações extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'configuracoes';

    protected $fillable = [

        'nome',
        'valor',
        'slug',

    ];

    public function destaque()
    {
        return $this->hasOne(Archives::class, 'reference_id', 'id')->where('table', 'configuracoes')->where('highlight', true);
    }
}
