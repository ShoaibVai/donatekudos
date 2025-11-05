<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeletedUser extends Model
{
    protected $table = 'deleted_users';

    protected $fillable = [
        'original_user_id',
        'user_data',
        'deleted_at',
        'deleted_by',
    ];

    protected $casts = [
        'user_data' => 'array',
        'deleted_at' => 'datetime',
    ];

    public $timestamps = false;
}
