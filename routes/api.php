<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;

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