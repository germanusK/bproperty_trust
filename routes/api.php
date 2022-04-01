<?php

use App\Http\Controllers\Customer;
use App\Http\Controllers\MailController;
use App\Http\Controllers\Order;
use App\Http\Controllers\Property;
use App\Http\Controllers\Schedule;
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
Route::get('/properties/latestTrending', [Property::class, 'getLatestTrending']);
Route::get('/properties/genericLatest', [Property::class, 'genericLatest']);
Route::get("/properties/some/count", [Property::class, 'customCount']);
Route::get("/properties/some", [Property::class, 'customGet']);
Route::get("/properties/count", [Property::class, 'countAll']);
Route::get("/properties/{id}", [Property::class, 'getById']);
Route::get("/properties", [Property::class, 'get']);
Route::put("/properties/{id}", [Property::class, 'update']);
Route::patch("/properties/{id}", [Property::class, 'patch']);
Route::delete("/properties/{id}", [Property::class, 'delete']);
Route::get("/uploads/images/{file_name}", [Property::class, 'getImage']);
Route::post("/notification/mail", [MailController::class, 'notify']);



Route::post("/schedules", [Schedule::class, 'store']);
Route::get("/schedules/some/count", [Schedule::class, 'customCount']);
Route::get("/schedules/some", [Schedule::class, 'customGet']);
Route::get("/schedules/count", [Schedule::class, 'countAll']);
Route::get("/schedules/{id}", [Schedule::class, 'getById']);
Route::get("/schedules", [Schedule::class, 'get']);
Route::put("/schedules/{id}", [Schedule::class, 'update']);
Route::patch("/schedules/{id}", [Schedule::class, 'patch']);
Route::delete("/schedules/{id}", [Schedule::class, 'delete']);




Route::post("/customers", [Customer::class, 'store']);
Route::get("/customers/some/count", [Customer::class, 'customCount']);
Route::get("/customers/some", [Customer::class, 'customGet']);
Route::get("/customers/count", [Customer::class, 'countAll']);
Route::get("/customers/{id}", [Customer::class, 'getById']);
Route::get("/customers", [Customer::class, 'get']);
Route::put("/customers/{id}", [Customer::class, 'update']);
Route::patch("/customers/{id}", [Customer::class, 'patch']);
Route::delete("/customers/{id}", [Customer::class, 'delete']);




Route::post("/orders", [Order::class, 'store']);
Route::get("/orders/some/count", [Order::class, 'customCount']);
Route::get("/orders/some", [Order::class, 'customGet']);
Route::get("/orders/count", [Order::class, 'countAll']);
Route::get("/orders/{id}", [Order::class, 'getById']);
Route::get("/orders", [Order::class, 'get']);
Route::put("/orders/{id}", [Order::class, 'update']);
Route::patch("/orders/{id}", [Order::class, 'patch']);
Route::delete("/orders/{id}", [Order::class, 'delete']);