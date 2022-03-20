<?php

use App\Http\Controllers\MailController;
use App\Http\Controllers\Property;
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

Route::post("/properties", [Property::class, 'store']);
Route::get("/properties/some/count", [Property::class, 'customCount']);
Route::get("/properties/some", [Property::class, 'customGet']);
Route::get("/properties/count", [Property::class, 'countAll']);
Route::get("/properties/{id}", [Property::class, 'getById']);
Route::get("/properties", [Property::class, 'get']);
Route::put("/properties/{id}", [Property::class, 'update']);
Route::patch("/properties/{id}", [Property::class, 'patch']);
Route::get("/uploads/images/file_name", [Property::class, 'getImahge']);
Route::delete("/properties/{id}", [Property::class, 'delete']);
Route::post("/notification/mail", [MailController::class, 'notify']);