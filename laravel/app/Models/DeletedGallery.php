<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeletedGallery extends Model
{
    use HasFactory;

    protected $table = 'deleted_galleries';

    protected $fillable = [
        'user_id',
        'image_path',
        'deleted_at',
    ];

    protected function casts(): array
    {
        return [
            'deleted_at' => 'datetime',
        ];
    }
}
