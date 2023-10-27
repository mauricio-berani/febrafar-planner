<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Task\TaskController;
use App\Http\Controllers\Api\Task\TypeController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
    Route::get('/match', 'findAllMatches')->name('findAllMatches');
    Route::get('/', 'findAll')->name('findAll');
    Route::get('/{user}', 'findOne')->name('findOne');
    Route::post('/', 'create')->name('create');
    Route::put('/{user}', 'update')->name('update');
    Route::delete('/{user}', 'delete')->name('delete');
});

Route::middleware(['auth:sanctum'])->prefix('task_types')->name('task_types.')->controller(TypeController::class)->group(function () {
    Route::get('/match', 'findAllMatches')->name('findAllMatches');
    Route::get('/', 'findAll')->name('findAll');
    Route::get('/{type}', 'findOne')->name('findOne');
    Route::post('/', 'create')->name('create');
    Route::put('/{type}', 'update')->name('update');
    Route::delete('/{type}', 'delete')->name('delete');
});

Route::middleware(['auth:sanctum'])->prefix('tasks')->name('tasks.')->controller(TaskController::class)->group(function () {
    Route::get('/match', 'findAllMatches')->name('findAllMatches');
    Route::get('/', 'findAll')->name('findAll');
    Route::get('/{task}', 'findOne')->name('findOne');
    Route::post('/', 'create')->name('create');
    Route::put('/{task}', 'update')->name('update');
    Route::delete('/{task}', 'delete')->name('delete');
});
