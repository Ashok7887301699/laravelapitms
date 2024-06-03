<?php

namespace App\Feature\User\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Hash;

class Otp extends Model
{
    protected $fillable = [
        'user_id', 'otp_hash', 'expires_at', 'failed_otp_login_attempts', 'otp_login_blocked_till',
    ];

    // Disable timestamps as they might not be necessary
    public $timestamps = true;

    /**
     * User relationship.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Set the OTP attribute and automatically hash it.
     *
     * @param  string  $value
     * @return void
     */
    public function setOtpAttribute($value)
    {
        $this->attributes['otp_hash'] = Hash::make($value);
    }

    // Add any necessary methods, accessors, and mutators
}
