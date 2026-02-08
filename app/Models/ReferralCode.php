<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ReferralCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'code',
        'max_uses',
        'times_used',
        'is_active',
    ];

    protected $casts = [
        'max_uses' => 'integer',
        'times_used' => 'integer',
        'is_active' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function referralUses()
    {
        return $this->hasMany(ReferralUse::class);
    }

    public function isUsable(): bool
    {
        return $this->is_active && $this->times_used < $this->max_uses;
    }

    public static function generateCode(): string
    {
        $prefix = config('referral.code_prefix', 'REF');
        $length = config('referral.code_length', 5);

        do {
            $code = $prefix . '-' . strtoupper(Str::random($length));
        } while (static::where('code', $code)->exists());

        return $code;
    }
}
