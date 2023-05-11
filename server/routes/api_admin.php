<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ChallengeController;
use App\Http\Controllers\Admin\EnumController;
use App\Http\Controllers\Admin\EquipmentController;
use App\Http\Controllers\Admin\ExerciseController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\MuscleController;

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

//=============== Auth ===============
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    //=============== Auth ===============
    Route::post('/logout', [AuthController::class, 'logout']);

    //=============== Upload file ===============
    // Route::get('/upload-temporary/{collection}', [BaseController::class, 'getUploadTemporaryUrl']);
    Route::get('/temporary-url/{collection}/{filename}', [MediaController::class, 'getTempUrl']);
    Route::post('/upload', [MediaController::class, 'upload']);
    //=============== User ===================
    //=============== Type ===================

    //=============== Group Exercise ===============

    //=============== Exercise ===============
    Route::get('/exercises', [ExerciseController::class, 'index']);
    Route::get('/exercises/group_tags', [ExerciseController::class, 'getGroupTags']);
    Route::get('/exercises/{id}', [ExerciseController::class, 'show']);
    Route::post('/exercises/search', [ExerciseController::class, 'search']);
    Route::post('/exercises', [ExerciseController::class, 'create']);
    Route::put('/exercises/{id}', [ExerciseController::class, 'update']);
    Route::delete('/exercises/{id}', [ExerciseController::class, 'destroy']);

    //=============== Equipments ===============
    Route::get('/equipments', [EquipmentController::class, 'index']);
    Route::post('/equipments', [EquipmentController::class, 'create']);
    Route::put('/equipments/{id}', [EquipmentController::class, 'update']);
    Route::delete('/equipments/{exercise}', [EquipmentController::class, 'delete']);

    //=============== Muscles ===============
    Route::get('/muscles', [MuscleController::class, 'index']);
    Route::post('/muscles', [MuscleController::class, 'create']);
    Route::put('/muscles/{id}', [MuscleController::class, 'update']);
    Route::delete('/muscles/{id}', [MuscleController::class, 'delete']);

    //=============== Challenge ===============
    Route::get('/challenges', [ChallengeController::class, 'index']);
    Route::get('/challenges/types', [ChallengeController::class, 'getChallengeTypes']);
    Route::get('/challenges/{id}', [ChallengeController::class, 'show']);
    Route::post('/challenges', [ChallengeController::class, 'create']);
    Route::put('/challenges/{id}', [ChallengeController::class, 'update']);
    Route::delete('/challenges/{id}', [ChallengeController::class, 'delete']);
    //=============== Plan ===============
    Route::get('/plans', [PlanController::class, 'index']);
    Route::get('/plans/{id}', [PlanController::class, 'show']);
    //=============== Plan Item ===============
    //=============== Result ===============
    //=============== Music ===============
    //=============== Feedback ===============
    //====================================
});
