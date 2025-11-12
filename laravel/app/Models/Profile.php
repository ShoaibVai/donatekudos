<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string|null $contact_info
 * @property string|null $wallet_addresses
 * @property string|null $qr_code_path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'contact_info',
        'wallet_addresses',
        'qr_code_path',
    ];

    protected function casts(): array
    {
        return [
            'contact_info' => 'json',
            'wallet_addresses' => 'json',
        ];
    }

    /**
     * Get the user that owns the profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
