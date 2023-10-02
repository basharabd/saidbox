<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AdminWallteController;
use App\Http\Controllers\Api\BranchController;
use App\Http\Controllers\Api\CaptainController;
use App\Http\Controllers\Api\CaptainWallteController;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\OrderStatusController;
use App\Http\Controllers\Api\RangController;
use App\Http\Controllers\Api\ReasonController;
use App\Http\Controllers\Api\SizeController;
use App\Http\Controllers\Api\StoreController;
use App\Http\Controllers\Api\StoreTypeController;
use App\Http\Controllers\Api\StoreWallteController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:captain')->group(function () {
    //Captains
    Route::post('/captain/logout', [CaptainController::class, 'logout']);
});



Route::get('getOrderstatus' , [OrderStatusController::class , 'getOrderTrackingStatus']);
//Admin wallet
Route::get('/admin/wallet', [AdminWallteController::class,'index']);

//Captain wallet
Route::get('/captain/wallet', [CaptainWallteController::class,'index']);

//Captain wallet
Route::get('/store/wallet', [StoreWallteController::class,'index']);

// Admin
Route::post('signin/admin', [AdminController::class, 'login']);
Route::post('signup/admin', [AdminController::class,'signup']);
Route::post('verify/admin', [AdminController::class, 'verify']);
Route::post('resend-code/admin', [AdminController::class, 'resendCode']);
Route::get('one/admin/{id}', [AdminController::class,'getAdmin']);
Route::get('admins', [AdminController::class,'index']);
Route::put('/update/admin/{id}', [AdminController::class, 'update']);
Route::delete('/destroy/admin/{id}', [AdminController::class, 'destroy']);

//Stores
Route::post('signin/store', [StoreController::class, 'login']);
Route::post('signup/store', [StoreController::class,'signup']);
Route::post('resend-code/store', [StoreController::class, 'resend_code']);
Route::post('verify/store', [StoreController::class, 'verify']);
Route::post('/logout/store', [StoreController::class, 'logout']);
Route::get('one/store/{id}', [StoreController::class,'getStore']);
Route::get('stores', [StoreController::class,'index']);
Route::put('/update/store/{id}', [StoreController::class, 'update']);
Route::delete('/destroy/store/{id}', [StoreController::class, 'destroy']);
Route::get('/stores/{storeId}/orders', [StoreController::class , 'getOrdersByStore']);
Route::put('/stores/{id}/update-image', [StoreController::class, 'updateImage']);




//Captain

Route::post('signin/captain', [CaptainController::class, 'login']);
Route::post('signup/captain', [CaptainController::class,'signup']);
Route::post('verify/captain', [CaptainController::class, 'verify']);
Route::post('resend-code/captain', [CaptainController::class, 'resendCode']);
Route::get('one/captain/{id}', [CaptainController::class,'getCaptain']);
Route::get('captains', [CaptainController::class,'index']);
Route::put('/update/captain/{id}', [CaptainController::class, 'update']);
Route::delete('/destroy/captain/{id}', [CaptainController::class, 'destroy']);



Route::middleware('auth:store')->group(function () {
    //Stores
    Route::post('/store/logout', [StoreController::class, 'logout']);
    //Orders

});

Route::get('getOrders' , [OrderController::class , 'getOrders']);
Route::post('storeOrder', [OrderController::class,'storeOrder']);
Route::post('/orders/cancel', [OrderController::class,'canceledOrder']);
Route::get('order/{orderId}', [OrderController::class, 'getOrder']);
Route::put('/orders/{order}', [OrderController::class, 'updateOrderStatus']);

Route::middleware('auth:admin')->group(function () {
    //Admins
    Route::post('/admin/logout', [AdminController::class, 'logout']);


});


//order_statuses

Route::apiResource('order_statuses', OrderStatusController::class);

Route::get('/order-status/tracking', [OrderStatusController::class, 'getOrderTrackingStatus']);


//store-types
    Route::apiResource('store-types' , StoreTypeController::class);


//reasons
    Route::apiResource('reasons', ReasonController::class);





//Sizes

    Route::get('/get/one/size/{sizeId}' , [SizeController::class , 'getsize']);
    Route::get('/get/size', [SizeController::class, 'sizes']);
    Route::post('/create/size', [SizeController::class,'storeSize']);
    Route::put('/update/size/{id}', [SizeController::class, 'updateSize']);
     Route::delete('/delete/size/{id}', [SizeController::class,'destroy']);


//Cities
    Route::get('/get/one/city/{cityId}' , [CityController::class , 'getcity']);
    Route::get('/get/city', [CityController::class, 'cities']);
    Route::post('/create/city', [CityController::class,'storeCity']);
    Route::put('/update/city/{id}', [CityController::class, 'updateCity']);

    Route::delete('/delete/city/{id}', [CityController::class,'destroy']);


//Rang
    Route::get('one/rang/{id}', [RangController::class,'getRang']);
    Route::get('rangs', [RangController::class, 'index']);
    Route::get('rangs/{id}', [RangController::class, 'show']);
    Route::post('rangs', [RangController::class, 'store']);

    Route::put('rangs/update/{id}', [RangController::class, 'update']);

    Route::delete('rangs/delete/{id}', [RangController::class, 'destroy']);

//branches
    Route::get('/get/one/branch/{branchId}' , [BranchController::class , 'getbranch']);
    Route::get('/get/branch', [BranchController::class, 'index']);
    Route::post('/create/branch', [BranchController::class,'store']);
    Route::put('/update/branch/{id}', [BranchController::class, 'update']);

    Route::delete('/delete/branch/{id}', [BranchController::class,'destroy']);
Route::get('getOrderstatus' , [OrderStatusController::class , 'getOrderTrackingStatus']);


Route::put('delivery-man-locations/{deliveryManLocation}' , [\App\Http\Controllers\Api\DeliveryManLocationsController::class , 'update']);
Route::get('delivery-man-locations/{deliveryManLocation}' , [\App\Http\Controllers\Api\DeliveryManLocationsController::class , 'show']);
