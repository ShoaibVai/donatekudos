<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Profile extends Model
{
    protected $fillable = [
        'user_id',
        'phone',
        'bio',
        'profile_url',
        'bitcoin_address',
        'ethereum_address',
        'other_addresses',
        'social_media',
    ];

    protected $casts = [
        'other_addresses' => 'array',
        'social_media' => 'array',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function walletQrCodes()
    {
        return $this->hasMany(WalletQrCode::class);
    }

    public function galleryItems()
    {
        return $this->hasMany(GalleryItem::class);
    }

    /**
     * Generate unique profile URL
     */
    public static function generateUniqueProfileUrl($name)
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;

        while (self::where('profile_url', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
