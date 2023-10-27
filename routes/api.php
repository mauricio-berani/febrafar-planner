<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\Task\{TypeController, TaskController};

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('auth')->name('auth.')->controller(AuthController::class)->group(function () {
    Route::post('/login', 'login');
    Route::post('/register', 'register');
    Route::middleware('auth:sanctum')->post('/logout', 'logout');
});

Route::middleware(['auth:sanctum'])->prefix('users')->name('users.')->controller(UserController::class)->group(function () {
    Route::get('/match', 'findAllMatches');
    Route::get('/', 'findAll');
    Route::get('/{user}', 'findOne');
    Route::post('/', 'create');
    Route::put('/{user}', 'update');
    Route::delete('/{user}', 'delete');
});

Route::middleware(['auth:sanctum'])->prefix('task_types')->name('task_types.')->controller(TypeController::class)->group(function () {
    Route::get('/match', 'findAllMatches');
    Route::get('/', 'findAll');
    Route::get('/{user}', 'findOne');
    Route::post('/', 'create');
    Route::put('/{user}', 'update');
    Route::delete('/{user}', 'delete');
});

Route::middleware(['auth:sanctum'])->prefix('tasks')->name('tasks.')->controller(TaskController::class)->group(function () {
    Route::get('/match', 'findAllMatches');
    Route::get('/', 'findAll');
    Route::get('/{user}', 'findOne');
    Route::post('/', 'create');
    Route::put('/{user}', 'update');
    Route::delete('/{user}', 'delete');
});
