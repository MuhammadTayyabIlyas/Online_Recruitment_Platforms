<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'balance',
        'currency',
    ];

    protected $casts = [
        'balance' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(WalletTransaction::class);
    }

    public function withdrawalRequests()
    {
        return $this->hasMany(WithdrawalRequest::class);
    }

    public function credit(float $amount, string $description, ?string $referenceType = null, ?int $referenceId = null): WalletTransaction
    {
        return DB::transaction(function () use ($amount, $description, $referenceType, $referenceId) {
            $this->lockForUpdate();
            $this->refresh();

            $this->balance += $amount;
            $this->save();

            return $this->transactions()->create([
                'type' => 'credit',
                'amount' => $amount,
                'balance_after' => $this->balance,
                'description' => $description,
                'reference_type' => $referenceType,
                'reference_id' => $referenceId,
            ]);
        });
    }

    public function debit(float $amount, string $description, ?string $referenceType = null, ?int $referenceId = null): WalletTransaction
    {
        return DB::transaction(function () use ($amount, $description, $referenceType, $referenceId) {
            $this->lockForUpdate();
            $this->refresh();

            if ($this->balance < $amount) {
                throw new \RuntimeException('Insufficient wallet balance.');
            }

            $this->balance -= $amount;
            $this->save();

            return $this->transactions()->create([
                'type' => 'debit',
                'amount' => $amount,
                'balance_after' => $this->balance,
                'description' => $description,
                'reference_type' => $referenceType,
                'reference_id' => $referenceId,
            ]);
        });
    }

    public function canWithdraw(): bool
    {
        return $this->balance >= config('referral.minimum_withdrawal', 50.00);
    }
}
