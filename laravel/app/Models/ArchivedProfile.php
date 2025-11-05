<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArchivedProfile extends Model
{
    protected $table = 'archived_profiles';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'original_profile_id',
        'user_id',
        'user_data',
        'gallery_data',
        'deleted_at',
        'expires_at',
    ];

    protected $casts = [
        'user_data' => 'array',
        'gallery_data' => 'array',
        'deleted_at' => 'datetime',
        'expires_at' => 'datetime',
    ];
}
