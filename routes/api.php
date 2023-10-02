<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\V1\AlbumController;
use App\Http\Controllers\V1\ImageManipulationController;

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

Route::get('employees', [EmployeeController::class, 'getEmployee']);
Route::get('employees/{id}', [EmployeeController::class, 'getEmployeeId']);
Route::post('addEmployee', [EmployeeController::class, 'addEmployee']);
Route::put('updateEmployee/{id}', [EmployeeController::class, 'updateEmployee']);
Route::delete('deleteEmployee/{id}', [EmployeeController::class, 'deleteEmployee']);

Route::prefix("v1")->group(function(){
    Route::apiResource("album", AlbumController::class);
    Route::get('image', [ImageManipulationController::class, 'index']);
    Route::get('image/by-album/{by_album}', [ImageManipulationController::class, 'byAlbum']);
    Route::get('image/{image}', [ImageManipulationController::class, 'show']);
    Route::post('image/resize', [ImageManipulationController::class, 'resize']);
    Route::delete('image/{image}', [ImageManipulationController::class, 'destroy']);
});