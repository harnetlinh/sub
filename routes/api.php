<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleDriveController;

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

Route::group(['middleware' => ['api']], function () {

    Route::group(['prefix' => 'googledrive'], function () {
        Route::get('/searchFiles',[GoogleDriveController::class, 'searchFiles']);
        // Route::post('/postInfoStudentBhyt',[GoogleDriveController::class, 'postInfoStudentBhyt']);
        // Route::post('/postInfoMemberBhyt',[GoogleDriveController::class, 'postInfoMemberBhyt']);
        // Route::post('/postCancelBhyt',[GoogleDriveController::class, 'postCancelBhyt']);
    });

});
