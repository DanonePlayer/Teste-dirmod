<?php
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExpenseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/users', [UserController::class, 'store']);
Route::post('/expenses', [ExpenseController::class, 'store']);
Route::get('/expenses', [ExpenseController::class, 'index']);
