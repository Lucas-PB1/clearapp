<?php

namespace App\Models\CMS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Archives extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'archives';

    protected $fillable = [
        'desc',
        'path',
        'name',
        'table',
        'title',
        'highlight',
        'extension',
        'reference_id'
    ];

    public function getPathAttribute()
    {
        $filePath = storage_path('app/' . $this->attributes['path']);

        if (file_exists($filePath)) {
            $filePath = str_replace('public/', '', $this->attributes['path']);
            return url('storage/' . $filePath);
        } else {
            return url('storage/example/sem-imagem.png');
        }
    }

}
