<?php

use App\Http\Controllers\Api\EntrepriseController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [EntrepriseController::class, 'register']);
Route::post('login', [EntrepriseController::class, 'login']);

Route::group([
    "middleware" =>['auth:sanctum']
], 
function(){
    Route::get('infosEntreprise/parcode/',[EntrepriseController::class, 'getEntrepriseParCodePromoteur']);
    Route::get('logout', [EntrepriseController::class, 'logout']);

});
//Route::put("updatelocalisation/", [EntrepriseController::class, 'updatelocalisationentreprise']);
//Route::get('infosEntreprise/parcode/',[EntrepriseController::class, 'getEntrepriseParCodePromoteur']);
