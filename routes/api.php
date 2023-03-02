<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\EvenementController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\OrganisateurController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TransfertController;
use App\Http\Controllers\AchatController;
use App\Http\Controllers\DemandeController;
use Illuminate\Mail\Transport\Transport;
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

// Authentified
Route::middleware(['auth:sanctum'])->group(function () {
    
    Route::resources([
        'achats' => AchatController::class,
        'categories' => CategorieController::class,
        'demandes' => DemandeController::class,
        'documents' => DocumentController::class,
        'evenements' => EvenementController::class,
        'organisateurs' => OrganisateurController::class,
        'pieces' => PiecesController::class,
        'tickets' => TicketController::class,
        'transferts' => TransfertController::class,
    ]);
    /*
    Route::apiResource('users/{id}/achats', UserController::class)->only('achats');
    Route::apiResource('organisateurs/{id}/evenements', OrganisateurController::class)->only('evenements');
    Route::apiResource('evenements/{id}/documents', EvenementController::class)->only('documents');
    Route::apiResource('evenements/{id}/tickets', EvenementController::class)->only('tickets');
    Route::apiResource('tickets/{id}/achats', TicketController::class)->only('achats');
    Route::apiResource('achats/{id}/ticket', AchatController::class)->only('ticket');
    Route::apiResource('achats/{id}/utilisateur', AchatController::class)->only('utilisateur');
    Route::apiResource('demandes/{id}/utilisateur', DemandeController::class)->only('utilisateur');
    Route::apiResource('demandes/{id}/pieces', DemandeController::class)->only('pieces');
    */

    Route::get('users/{id}/achats', [UserController::class, 'achats']);
    Route::get('organisateurs/{id}/evenements', [OrganisateurController::class, 'index']);
    Route::get('evenements/{id}/documents', [EvenementController::class, 'documents']);
    Route::get('evenements/{id}/tickets', [EvenementController::class, 'tickets']);
    Route::get('tickets/{id}/achats', [TicketController::class, 'achats']);
    Route::get('achats/{id}/ticket', [AchatController::class, 'ticket']);
    Route::get('achats/{id}/utilisateur', [AchatController::class, 'utilisateur']);
    Route::get('demandes/{id}/utilisateur', [DemandeController::class, 'utilisateur']);
    Route::get('demandes/{id}/pieces', [DemandeController::class, 'pieces']);
    
});

//Route::apiResource('posts', PostController::class)->middleware('auth:sanctum');