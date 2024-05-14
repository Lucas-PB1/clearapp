<?php

namespace App\Models\CMS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Crud extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cruds';

    protected $fillable = [
        
        'titulo',

    ];
}