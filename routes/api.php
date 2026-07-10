<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route as RouteFacade;

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

RouteFacade::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

 
RouteFacade::get('/message', function () {
    return response()->json([
        'message' => 'Bonjour depuis Laravel'
    ]);
});
