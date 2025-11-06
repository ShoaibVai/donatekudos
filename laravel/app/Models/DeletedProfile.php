<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeletedProfile extends Model
{
    use HasFactory;

    protected $table = 'deleted_profiles';

    protected $fillable = [
        'user_id',
        'contact_info',
        'wallet_addresses',
        'qr_code_path',
        'deleted_at',
    ];

    protected function casts(): array
    {
        return [
            'contact_info' => 'json',
            'wallet_addresses' => 'json',
            'deleted_at' => 'datetime',
        ];
    }
}
