<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OtpVerification extends Model
{
    use HasFactory;

    protected $table = 'otp_verifications';

    protected $fillable = [
        'user_id',
        'otp_code',
        'expires_at',
        'attempts',
        'verified_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'verified_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
