<?php

use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\ConvertRequest;
use App\Http\Requests\Api\RatesRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('api')->prefix('v1')->group(function() {
    Route::get('/', function (Request $request) {

        if ($request->get('method') == 'rates') {
            return call_user_func([new ApiController(), 'rates'], app()->make(RatesRequest::class));
        }
    
        return ApiController::makeError('Invalid method', 403);
    });

    Route::post('/', function (Request $request) {
       
        if ($request->post('method') == 'convert') {
            return call_user_func([new ApiController(), 'convert'], app()->make(ConvertRequest::class));
        }
    
        return ApiController::makeError('Invalid method', 403);
    });
});