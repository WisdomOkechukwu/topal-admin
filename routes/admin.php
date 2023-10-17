<?php

use App\Http\Controllers\ChartController;
use App\Http\Controllers\Customer\LoansController as CustomerLoansController;
use App\Http\Controllers\Customer\ProfileController as CustomerProfileController;
use App\Http\Controllers\Customer\SavingsController as CustomerSavingsController;
use App\Http\Controllers\Customer\TransactionController as CustomerTransactionController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\LoansController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\OverviewController;
use App\Http\Controllers\SavingsController;
use App\Http\Controllers\StatisticsController;
use Illuminate\Support\Facades\Route;


Route::prefix("savings")->name("savings.")->group(function () {
    Route::GET('/', [SavingsController::class,'index'])->name('index');
    Route::GET('/show/{saving}', [SavingsController::class,'show']);
});

Route::prefix("loans")->name("loans.")->group(function () {
    Route::GET('/', [LoansController::class,'index'])->name('index');
    Route::GET('/show/{loan}', [LoansController::class,'show']);
    Route::POST('/approve', [LoansController::class,'approve']);
    Route::POST('/decline', [LoansController::class,'decline']);
});

Route::prefix("transactions")->name("transactions.")->group(function () {
    Route::GET('/', [TransactionController::class,'index'])->name('index');
    Route::GET('/show/{transaction}', [TransactionController::class,'show']);
});

Route::prefix("customer")->name("customer.")->group(function () {
    Route::GET('/show/{customer}', [CustomerProfileController::class,'show']);
    Route::PUT('/update/{customer}', [CustomerProfileController::class,'update']);
    Route::PUT('/update/password/{customer}', [CustomerProfileController::class,'update_password']);
    Route::POST('/update/toAdmin/{customer}', [CustomerProfileController::class,'update_to_admin']);
    Route::POST('/update/downgradeAdmin/{customer}', [CustomerProfileController::class,'downgradeAdmin']);
    Route::POST('/delete', [CustomerProfileController::class,'delete']);

    // Loans, savings and transactions
    Route::GET('/loans/{customer}', [CustomerLoansController::class,'loans']);
    Route::GET('/savings/{customer}', [CustomerSavingsController::class,'savings']);
    Route::GET('/transactions/{customer}', [CustomerTransactionController::class,'transactions']);
});

Route::prefix("profile")->name("profile.")->group(function () {
    Route::GET('/', [ProfileController::class,'index'])->name('index');
    Route::PUT('/update/{user}', [ProfileController::class,'update']);
    Route::PUT('/update/password/{user}', [ProfileController::class,'update_password']);
});

Route::prefix("customers")->name("customers.")->group(function () {
    Route::GET('/', [CustomersController::class,'all_users'])->name('profile');
});

Route::prefix("overview")->name("overview.")->group(function () {
    Route::GET('/', [OverviewController::class,'index'])->name('index');
});

Route::prefix("statistics")->name("statistics.")->group(function () {
    Route::GET('/', [StatisticsController::class,'index'])->name('index');
});

Route::prefix("chart")->name("chart.")->group(function () {
    Route::GET('/transactions-chart/{date?}/{status?}', [ChartController::class,'transactions'])->name('transactions');
    Route::GET('/savings-chart/{date?}/{status?}', [ChartController::class,'savings'])->name('savings');
    Route::GET('/loans-chart/{date?}/{status?}', [ChartController::class,'loans'])->name('loans');
});

Route::POST('/logout', [LogoutController::class,'logout'])->name('logout');



