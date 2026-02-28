<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserTypeController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\QuestionController;
use App\Http\Controllers\Api\AdminAuthController;
use App\Http\Controllers\Api\AdminUserController;


Route::get('/', function () {
    return response()->json([
        'message' => 'API Prueba Técnica Ariguani funcionando correctamente 🚀'
    ]);
});

Route::get('/user-types', [UserTypeController::class, 'index']);
Route::post('/register', [RegisterController::class, 'store']);
Route::get('/questions/{userTypeId}', [QuestionController::class, 'byUserType']);
Route::post('/admin/login', [AdminAuthController::class, 'login']);

Route::middleware('auth:admin')->group(function () {

    Route::get('/admin/users', [AdminUserController::class, 'index']);
    Route::patch('/admin/users/{id}/toggle-status', [AdminUserController::class, 'toggleStatus']);
    Route::patch('/admin/user-types/{id}/toggle', [UserTypeController::class, 'toggle']);

});