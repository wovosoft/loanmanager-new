<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();
        static::creating(function (self $loan) {
            $loan->due_amount = $loan->loan_amount;
        });
    }

    public function account(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function borrower(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Borrower::class);
    }

    public function installments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Installment::class);
    }

    public function scopeActive(Builder $builder): Builder
    {
        return $builder->where("status", "=", 'active');
    }
}
