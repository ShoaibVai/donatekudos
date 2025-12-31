<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class GalleryImage extends Model
{
    protected $fillable = [
        'profile_id',
        'image_path',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    /**
     * Boot method to handle image deletion
     */
    protected static function boot()
    {
        parent::boot();
        
        static::deleting(function ($image) {
            // Delete physical file when model is deleted
            if ($image->image_path && Storage::disk('public')->exists($image->image_path)) {
                Storage::disk('public')->delete($image->image_path);
            }
        });
    }

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    /**
     * Get full URL for the image
     */
    public function getUrlAttribute()
    {
        return Storage::url($this->image_path);
    }
}
