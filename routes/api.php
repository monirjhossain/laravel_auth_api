<?php

use App\Http\Controllers\dummyAPI;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Models\Task;
use App\Models\User;
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

Route::post('/register',[UserController::class,'register']);
Route::post('/login',[UserController::class,'login']);

Route::middleware('auth:sanctum')->group( function(){
    Route::get('tasks',[TaskController::class,'index']);
    Route::post('tasks-store',[TaskController::class,'store']);
    Route::post('tasks-show/{id}',[TaskController::class,'show']);
    Route::post('tasks-update/{task}',[TaskController::class,'update']);
    Route::post('tasks-delete/{id}',[TaskController::class,'destroy']);
});

// Route::get("data",[dummyAPI::class, 'getdata']);
