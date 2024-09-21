<?php

use App\Http\Controllers\AirportController;
use App\Http\Controllers\API\AirCraftApiController;
use App\Http\Controllers\API\AirportApiController;
use App\Http\Controllers\API\AuthApiController;
use App\Http\Controllers\API\DinghiesApiController;
use App\Http\Controllers\API\FlightPlanApiController;
use App\Http\Controllers\API\FlightRulesApiController;
use App\Http\Controllers\API\JacketsApiController;
use App\Http\Controllers\API\MonitoringApiController;
use App\Http\Controllers\API\PoliceRankApiController;
use App\Http\Controllers\API\RadioApiController;
use App\Http\Controllers\API\RoleApiController;
use App\Http\Controllers\API\SpeedApiController;
use App\Http\Controllers\API\StatusApiController;
use App\Http\Controllers\API\SurvivalEquipmentApiController;
use App\Http\Controllers\API\TorbulanceApiController;
use App\Http\Controllers\API\TypeFlightApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UsersApiController;
use App\Models\Aircraft;

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


Route::prefix('/v1')->group(function () {

  
});
