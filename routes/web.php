<?php

use App\Http\Controllers\ExpenseController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/expenses', [ExpenseController::class, 'index'])
    ->name('expenses.index');

Route::post('/expenses', [ExpenseController::class, 'store'])
    ->name('expenses.store');