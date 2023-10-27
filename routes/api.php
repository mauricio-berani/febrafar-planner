<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\{LoginController, LogoutController, RegisterController};
use App\Http\Controllers\Api\User\{
    FindAllController as UserFindAllController,
    FindAllMatchesController as UserFindAllMatchesController,
    FindOneController as UserFindOneController,
    CreateController as UserCreateController,
    UpdateController as UserUpdateController,
    DeleteController as UserDeleteController
};
use App\Http\Controllers\Api\TaskCategory\{
    FindAllController as TaskCategoryFindAllController,
    FindAllMatchesController as TaskCategoryFindAllMatchesController,
    FindOneController as TaskCategoryFindOneController,
    CreateController as TaskCategoryCreateController,
    UpdateController as TaskCategoryUpdateController,
    DeleteController as TaskCategoryDeleteController
};

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

Route::prefix('auth')->name('auth.')->group(function () {
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/register', [RegisterController::class, 'register']);
    Route::middleware('auth:sanctum')->post('/logout', [LogoutController::class, 'logout']);
});

Route::middleware(['auth:sanctum'])->prefix('users')->name('users.')->group(function () {
    Route::get('/match', [UserFindAllMatchesController::class, 'findAllMatches']);
    Route::get('/', [UserFindAllController::class, 'findAll']);
    Route::get('/{user}', [UserFindOneController::class, 'findOne']);
    Route::post('/', [UserCreateController::class, 'create']);
    Route::put('/{user}', [UserUpdateController::class, 'update']);
    Route::delete('/{user}', [UserDeleteController::class, 'delete']);
});

Route::middleware(['auth:sanctum'])->prefix('task_categories')->name('task_categories.')->group(function () {
    Route::get('/match', [TaskCategoryFindAllController::class, 'findAllMatches']);
    Route::get('/', [TaskCategoryFindAllMatchesController::class, 'findAll']);
    Route::get('/{user}', [TaskCategoryFindOneController::class, 'findOne']);
    Route::post('/', [TaskCategoryCreateController::class, 'create']);
    Route::put('/{user}', [TaskCategoryUpdateController::class, 'update']);
    Route::delete('/{user}', [TaskCategoryDeleteController::class, 'delete']);
});
