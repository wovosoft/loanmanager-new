<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrower extends Model
{
    use HasFactory;
    public function accounts()
    {
        return $this->hasMany(Account::class);
    }
    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
    public function installments()
    {
        return $this->hasMany(Installment::class);
    }
}
