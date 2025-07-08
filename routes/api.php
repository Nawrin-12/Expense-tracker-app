<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExpenseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/test', function (Request $request) {
    return "Hello World";
});

// Authentication Routes
Route::post('/login', [AuthController::class, 'login'])->middleware(['throttle:limit']);
Route::get('/login', [AuthController::class, 'loginUser'])->name('loginPage');


Route::post('/register', [AuthController::class, 'register']);
Route::get('/register', [AuthController::class, 'registerUser']);

Route::get('/forgot-password', [AuthController::class, 'forgotPass']);
Route::post('/forget-password', [AuthController::class, 'forgetPassword']);

Route::post('/reset-password', [AuthController::class, 'resetPassword'])->middleware(['throttle:limit']);
// Registration (name, email, msisdn, password)

// Expense Handle Routes
Route::post('/expense-store',[ExpenseController::class, 'store']);
Route::post('/expense-update',[ExpenseController::class, 'update']);
Route::post('/expense-delete',[ExpenseController::class, 'destroy']);
Route::post('/read',[ExpenseController::class, 'read']);

