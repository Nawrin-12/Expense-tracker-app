<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExpenseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/test', function (Request $request) {
    return "Hello World";
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'GetLogin']);
Route::post('/login', [AuthController::class, 'login'])->middleware(['throttle:limit']);

Route::post('/register', [AuthController::class, 'register']);

Route::post('/forget-password', [AuthController::class, 'forgetPassword']);

Route::get('/reset-password', [AuthController::class, 'GetResetPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->middleware(['throttle:limit']);
// Registration (name, email, msisdn, password)

// Expense Handle Routes
Route::post('/expense-store',[ExpenseController::class, 'store']);
Route::get('/expense-create',[ExpenseController::class, 'create']);

Route::put('/expense-update',[ExpenseController::class, 'update']);
Route::get('/expense-update',[ExpenseController::class, 'GetUpdate']);

Route::delete('/expense-delete',[ExpenseController::class, 'destroy']);

Route::get('/read',[ExpenseController::class, 'read']);

