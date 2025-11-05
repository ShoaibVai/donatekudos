<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Profile extends Model
{
    protected $table = 'profiles';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'user_id',
        'username',
        'bio',
        'avatar_url',
        'contact_info',
        'wallet_addresses',
        'qr_code_url',
    ];

    protected $casts = [
        'contact_info' => 'array',
        'wallet_addresses' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the gallery images for this profile
     */
    public function galleries(): HasMany
    {
        return $this->hasMany(Gallery::class, 'profile_id', 'id');
    }

    /**
     * Get archived version of this profile
     */
    public function archived()
    {
        return ArchivedProfile::where('original_profile_id', $this->id)->latest()->first();
    }
}
