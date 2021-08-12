<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Installment extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();
        static::created(function (self $installment) {
            $loan = $installment->loan;
            $loan->collection_amount += $installment->amount;
            $loan->due_amount -= $installment->amount;
            $loan->last_collection_date = $installment->date;
            $loan->saveOrFail();
        });
        static::deleted(function (self $installment) {
            $loan = $installment->loan;
            $loan->collection_amount -= $installment->amount;
            $loan->due_amount += $installment->amount;

            $lastLoan = self::query()->select(['id', 'date'])->latest()->first();
            $loan->last_collection_date = $lastLoan ? $lastLoan->date : null;
            $loan->saveOrFail();

            //when deleted: the next entries needed to be fixed with updated values
            self::query()
                ->where("loan_id", "=", $loan->id)
                ->where("created_at", ">", $installment->created_at)
                ->each(function (self $nextInstallment) use ($installment) {
                    $nextInstallment->previous_debt += $installment->amount ?? 0;
                    $nextInstallment->current_debt += $installment->amount ?? 0;
                    $nextInstallment->saveOrFail();
                });
        });
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function borrower(): BelongsTo
    {
        return $this->belongsTo(Borrower::class);
    }

    public function loan(): BelongsTo
    {
        return $this->belongsTo(Loan::class);
    }
}
