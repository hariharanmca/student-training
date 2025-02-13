<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TrainingScheduleController;
use App\Http\Controllers\StudentTrainingController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
    Route::middleware('role:student')->group(function () {
            Route::get('courses', [CourseController::class, 'index']);
            Route::post('student-training/opt-in', [StudentTrainingController::class, 'optIn']);
            Route::post('student-training/opt-out', [StudentTrainingController::class, 'optOut']);
    });
    
        Route::middleware('role:admin')->group(function () {
            Route::apiResource('courses', CourseController::class);
            Route::apiResource('students', StudentController::class);
            Route::apiResource('schedules', TrainingScheduleController::class);
        });
});
