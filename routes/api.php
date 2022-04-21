<?php

use App\Http\Controllers\Controller;
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
Route::get("/properties/related/{id}", [Property::class, 'getRelatedProperty']);
Route::get("/properties/count", [Property::class, 'countAll']);
Route::get("/properties/{id}", [Property::class, 'getById']);
Route::get("/properties", [Property::class, 'get']);
Route::put("/properties/{id}", [Property::class, 'update']);
Route::patch("/properties/{id}", [Property::class, 'patch']);
Route::delete("/properties/{id}", [Property::class, 'delete']);
Route::get("/uploads/images/{file_name}", [Property::class, 'getImage']);
Route::post("/notification/recipient", [MailController::class, 'notify']);



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



// MESSAGES
Route::post("/messages", [Order::class, 'store']);
Route::get("/messages/some/count", [Order::class, 'customCount']);
Route::get("/messages/some", [Order::class, 'customGet']);
Route::get("/messages/count", [Order::class, 'countAll']);
Route::get("/messages/{id}", [Order::class, 'getById']);
Route::get("/messages", [Order::class, 'get']);
Route::put("/messages/{id}", [Order::class, 'update']);
Route::patch("/messages/{id}", [Order::class, 'patch']);
Route::delete("/messages/{id}", [Order::class, 'delete']);




// Groups
Route::post('/groups', [Controller::class, 'createGroup']);
Route::get('/groups', [Controller::class, 'getGroups']);
Route::put('/groups/{id}', [Controller::class, 'updateGroup']);
Route::delete('/groups/{id}', [Controller::class, 'deleteGroup']);
// Categories
Route::post('/categories', [Controller::class, 'createCategory']);
Route::get('/categories/{group}', [Controller::class, 'getCategoriesByGroup']);
Route::get('/categories', [Controller::class, 'getCategories']);
Route::put('/categories/{id}', [Controller::class, 'updateCategory']);
Route::delete('/categories/{id}', [Controller::class, 'deleteCategory']);
// Grades
Route::post('/grades', [Controller::class, 'createGrade']);
Route::get('/grades', [Controller::class, 'getGrades']);
Route::put('/grades/{id}', [Controller::class, 'updateGrade']);
Route::delete('/grades/{id}', [Controller::class, 'deleteGrade']);



// SEARCH
Route::get('/search/seachParams', [Controller::class, 'search']);