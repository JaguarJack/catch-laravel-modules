<?php
// +----------------------------------------------------------------------
// | CatchAdmin [Just Like ～ ]
// +----------------------------------------------------------------------
// | Copyright (c) 2017~2021 https://catchadmin.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( https://github.com/JaguarJack/catchadmin-laravel/blob/master/LICENSE.md )
// +----------------------------------------------------------------------
// | Author: JaguarJack [ njphper@gmail.com ]
// +----------------------------------------------------------------------

use Illuminate\Support\Facades\Route;
use CatchAdmin\Permissions\Http\Controllers\UserController;
use CatchAdmin\Permissions\Http\Controllers\AuthController;
use CatchAdmin\Permissions\Http\Controllers\DepartmentController;
use CatchAdmin\Permissions\Http\Controllers\RoleController;
use CatchAdmin\Permissions\Http\Controllers\JobController;
use CatchAdmin\Permissions\Http\Controllers\PermissionController;

Route::prefix('')->group(function () {
    // users resource
    Route::apiResource('users', UserController::class);
    Route::get('user/info', [AuthController::class, 'user']);
    Route::get('export/users', [UserController::class, 'export']);
    // department resource
    Route::apiResource('departments', DepartmentController::class);
    // roles resource
    Route::apiResource('roles', RoleController::class);
    Route::get('/role/permissions/{id}', [RoleController::class, 'permissions']);
    Route::apiResource('jobs', JobController::class);
    Route::apiResource('permissions', PermissionController::class);
});
