<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\FormController;
use App\Http\Controllers\API\ScoreController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => 'auth:sanctum'], function () {
    // Crud Form
    Route::get('/show', [FormController::class, 'show']);
    Route::get('/get-all', [FormController::class, 'getAll']);
    Route::get('/get-detail/{id}', [FormController::class, 'getDetail']);
    Route::post('/create', [FormController::class, 'create']);
    Route::put('/update/{id}', [FormController::class, 'update']);
    Route::delete('/delete/{id}', [FormController::class, 'delete']);

    // CRUd Score
    Route::get('/get-all-score', [ScoreController::class, 'getAll']);
    Route::get('/get-detail-score/{id}', [ScoreController::class, 'getDetail']);
    Route::post('/create-score', [ScoreController::class, 'create']);
    Route::put('/update-score/{id}', [ScoreController::class, 'update']);
    Route::delete('/delete-score/{id}', [ScoreController::class, 'delete']);

    Route::get('/get-student/{id}', [ScoreController::class, 'getStudent']);

    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
