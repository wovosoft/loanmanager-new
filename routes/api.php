<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\BorrowerController;
use App\Http\Controllers\InstallmentController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('users', [UserController::class, 'index'])->name("users.index");
Route::post('borrowers', [BorrowerController::class, 'index'])->name("borrowers.index");
Route::post('borrowers/search', [BorrowerController::class, 'search'])->name("borrowers.search");
Route::post('accounts', [AccountController::class, 'index'])->name("accounts.index");
Route::post('accounts/search', [AccountController::class, 'search'])->name("accounts.search");
Route::post('accounts/by-borrower-id', [AccountController::class, 'listByBorrowerId'])->name("accounts.ByBorrowerId");
Route::post('loans', [LoanController::class, 'index'])->name("loans.index");
Route::post('loans/by-account-no', [LoanController::class, 'getLoanByAccountNo'])->name("loans.ByAccountNo");
Route::post('installments', [InstallmentController::class, 'index'])->name("installments.index");
Route::post('installments/store', [InstallmentController::class, 'store'])->name("installments.store");
Route::delete('installments/trash/{installment}', [InstallmentController::class, 'trash'])->name("installments.trash");
