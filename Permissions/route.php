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
use CatchAdmin\Permissions\Http\Controllers\UsersController;
use CatchAdmin\Permissions\Http\Controllers\AuthController;
use CatchAdmin\Permissions\Http\Controllers\DepartmentController;
use CatchAdmin\Permissions\Http\Controllers\RolesController;
use CatchAdmin\Permissions\Http\Controllers\JobsController;
use CatchAdmin\Permissions\Http\Controllers\PermissionsController;

Route::prefix('')->group(function () {
    // users resource
    Route::apiResource('users', UsersController::class);
    Route::get('user/info', [AuthController::class, 'user']);
    Route::get('export/users', [UsersController::class, 'export']);
    // department resource
    Route::apiResource('departments', DepartmentController::class);
    // roles resource
    Route::apiResource('roles', RolesController::class);
    Route::get('/role/permissions/{id}', [RolesController::class, 'permissions']);
    Route::apiResource('jobs', JobsController::class);
    Route::apiResource('permissions', PermissionsController::class);

});
