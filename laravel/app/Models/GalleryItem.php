<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryItem extends Model
{
    protected $fillable = [
        'profile_id',
        'image_path',
        'description',
        'category',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}
