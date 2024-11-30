<?php

use App\Http\Controllers\Auth\User\UserAuthController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\Admin\AdminAuthController;
use App\Http\Controllers\TasksAdminActions\TaskAdminActionsController;
use App\Http\Controllers\TaskUserActions\TaskUserActionsController;

Route::middleware(['LoginValidation'])->group(function (){
    Route::post('admin/login',[AdminAuthController::class,'adminLogin']);
    Route::post('user/login',[UserAuthController::class,'userLogin']);
});
Route::middleware(['CheckRole:admin'])->group(function () {
    Route::resource('task',TaskAdminActionsController::class);
});

// User routes
Route::middleware(['CheckRole:user'])->group(function () {
    Route::put('/task/{task_id}/subtask/{subtask_id}/update', [TaskUserActionsController::class, 'update']);
});

Route::get('/hash',function (){
    return Hash::make("mahmoud20##20##");
});
