<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;
    public function borrower()
    {
        return $this->belongsTo(Borrower::class);
    }
    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
}
