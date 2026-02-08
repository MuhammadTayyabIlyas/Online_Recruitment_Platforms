<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferralUse extends Model
{
    use HasFactory;

    protected $fillable = [
        'referral_code_id',
        'referred_user_id',
        'application_type',
        'application_id',
        'status',
        'credited_at',
    ];

    protected $casts = [
        'credited_at' => 'datetime',
    ];

    public function referralCode()
    {
        return $this->belongsTo(ReferralCode::class);
    }

    public function referredUser()
    {
        return $this->belongsTo(User::class, 'referred_user_id');
    }
}
