<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\EvenementController;
use App\Http\Controllers\DocumentController;
use Illuminate\Support\Facades\Auth;

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

/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/

Route::any('/', function() {echo "Ticket shop API";});

// email, password
Route::post('authentication', [AuthController::class, 'loginUser']);

// nom, prenom, username, email, password
Route::post('users', [AuthController::class, 'createUser']);

Route::middleware(['auth:sanctum'])->group(function () {
    
    Route::apiResource('evenement', EvenementController::class);
});
Route::apiResource('document', DocumentController::class);

//Route::apiResource('posts', PostController::class)->middleware('auth:sanctum');