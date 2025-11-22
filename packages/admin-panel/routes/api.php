<?php

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

/*
|--------------------------------------------------------------------------
| Mobile App API Routes
|--------------------------------------------------------------------------
|
| Unified API endpoint for mobile app (Vue3)
| All requests use POST /apiw with action-based routing
|
*/

use App\Http\Controllers\Api\ApiController;

// Main API endpoint for mobile app
Route::post('/apiw', [ApiController::class, 'handle']);
