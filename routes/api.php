<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Series;
use Illuminate\Support\Facades\Hash;
use \Illuminate\Support\Facades\Auth;
use App\Models\User;
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

Route::middleware('auth: ')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth: ')->group(function (){
        Route::apiResource('/series', App\Http\Controllers\Api\SeriesController::class);

    Route::get('series/{series}/seasons', function(Series $series){
        return $series->seasons;
    });

    Route::get('series/{series}/episodes', function (Series $series) {
        return $series->episodes;
    });

    Route::patch('/episodes/{episode}', function (\App\Models\Episode $episode, Request $request) {
        $episode->watched = $request->watched;
        $episode->save();

        return $episode;
    });
});

