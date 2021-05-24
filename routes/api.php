<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Role;

/* events?between=2021-09-14&and=2021-10-20 */

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

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::group(['prefix'=>'v1','as'=>'api.v1.'], function(){
    
    Route::post('auth', [App\Http\Controllers\Api\V1\Users\AuthController::class, 'login']);
   
    Route::post('users', [App\Http\Controllers\Api\V1\Users\UserController::class, 'store']);

    Route::get('events', [App\Http\Controllers\Api\V1\EventsAgro\EventController::class, 'index'])
                ->name('events'); 
    
    Route::get('events/{id}', [App\Http\Controllers\Api\V1\EventsAgro\EventController::class, 'show']); 

    Route::get('events/{id}/addr', [App\Http\Controllers\Api\V1\EventsAgro\EventController::class, 'addr']); 

    Route::get('events/{id}/geo-location', [App\Http\Controllers\Api\V1\EventsAgro\EventController::class, 'geoLocation']);
    
    Route::get('producers/{id}/events', [App\Http\Controllers\Api\V1\Producers\ProducerController::class, 'events'])
                    ->name('producer.events');

    Route::get('geo/{lt}/{lng}/{val}', [App\Http\Controllers\Api\V1\GeoLocation\GeographicLocationController::class, 'circundantes']);

    Route::get('events/{lt}/{lng}/{val}', [App\Http\Controllers\Api\V1\EventsAgro\EventController::class, 'circundantes']);

    Route::get('events/date/between/{date1}/{date2}', [App\Http\Controllers\Api\V1\EventsAgro\EventController::class, 'dateBetween']);

    Route::get('news', [App\Http\Controllers\Api\V1\News\NewsController::class, 'index']);

    Route::get('news/{id}', [App\Http\Controllers\Api\V1\News\NewsController::class, 'show']);

    Route::get('shops/{id}', [App\Http\Controllers\Api\V1\Shop\ProducerShopController::class, 'show']);

    Route::middleware(['auth:sanctum', 'role:'.Role::REGISTERED_USER])->group(function () {
        Route::delete('auth', [App\Http\Controllers\Api\V1\Users\AuthController::class, 'logout']);
        Route::apiResource('producers', App\Http\Controllers\Api\V1\Producers\ProducerController::class)->only('store');
        Route::apiResource('users', App\Http\Controllers\Api\V1\Users\UserController::class)->except(['store','index']);
        Route::get('users/{id}/addrs', [App\Http\Controllers\Api\V1\Users\UserController::class, 'addrs'])
                    ->name('user.addrs');
        Route::apiResource('addrs', App\Http\Controllers\Api\V1\Addrs\AddrController::class)->only(['store', 'show', 'update', 'destroy']);
        Route::get('addrs/{id}/geo-location', [App\Http\Controllers\Api\V1\Addrs\AddrController::class, 'geoLocation']);    
        Route::apiResource('geo-locations', App\Http\Controllers\Api\V1\GeoLocation\GeographicLocationController::class)->only(['store', 'show']);    
        Route::get('shops/shipping-price', [App\Http\Controllers\Api\V1\Shop\ProducerShopController::class, 'calcDeliveryPrice']);
        
    });

    Route::middleware(['auth:sanctum', 'role:'.Role::PRODUCER])->group(function () {
        Route::apiResource('producers', App\Http\Controllers\Api\V1\Producers\ProducerController::class)->except('store');
        Route::apiResource('events', App\Http\Controllers\Api\V1\EventsAgro\EventController::class)->except(['index']);
        Route::apiResource('news', App\Http\Controllers\Api\V1\News\NewsController::class)->except(['index', 'show']); 
        Route::apiResource('shops', App\Http\Controllers\Api\V1\Shop\ProducerShopController::class)->except(['index', 'show']); 
    });

    Route::middleware(['auth:sanctum', 'role:'.Role::ADMIN])->group(function () {
        Route::group(['prefix'=>'admin','as'=>'api.v1.'], function(){
            Route::apiResource('users', App\Http\Controllers\Api\V1\Users\UserController::class);
            Route::apiResource('producers', App\Http\Controllers\Api\V1\Producers\ProducerController::class);
            Route::apiResource('addrs', App\Http\Controllers\Api\V1\Addrs\AddrController::class);
            Route::apiResource('geo-locations', App\Http\Controllers\Api\V1\GeoLocation\GeographicLocationController::class);
            Route::apiResource('news', App\Http\Controllers\Api\V1\News\NewsController::class);
            Route::apiResource('shops', App\Http\Controllers\Api\V1\Shop\ProducerShopController::class); 
        });
    });
});