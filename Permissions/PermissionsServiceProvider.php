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

namespace CatchAdmin\Permissions;

use CatchAdmin\Permissions\Events\LoginLog;
use CatchAdmin\Permissions\Events\OperateLog;
use CatchAdmin\Permissions\Http\Controllers\AuthController;
use CatchAdmin\Permissions\Http\Middleware\Authenticate;
use CatchAdmin\Permissions\Http\Middleware\Permissions;
use Catcher\Providers\CatchModuleServiceProvider;
use Illuminate\Support\Facades\Route;
use CatchAdmin\Permissions\Http\Controllers\BuildController;
use CatchAdmin\Permissions\Listeners\LoginLog as LoginLogListener;
use CatchAdmin\Permissions\Listeners\OperateLog as OperateLogListener;

class PermissionsServiceProvider extends CatchModuleServiceProvider
{
    protected $name = 'Permissions';

    /**
     * @var string[]
     */
    protected $listeners = [
        LoginLog::class => LoginLogListener::class,

        OperateLog::class => OperateLogListener::class
    ];

    /**
     * boot
     *
     * @time 2021年08月17日
     * @return void
     */
    public function boot()
    {
        $this->registerExtraRoute();

        $this->app->terminating(function () {
            if (request('permission_id')) {
                event(new OperateLog(request('permission_id')));
            }
        });

        $this->setDefaultGuard();
    }

    /**
     * middleware
     *
     * @time 2021年08月14日
     * @return void
     */
    protected function registerMiddlewares()
    {
        $this->app['router']->middlewareGroup(
            config('catch.catch_auth_middleware_alias'), [
            Authenticate::class,
            Permissions::class,
        ]);
    }

    /**
     * register login route
     *
     * @time 2021年08月14日
     * @return void
     */
    protected function registerExtraRoute()
    {
        Route::prefix('api')->group(function (){
            Route::post('login', [AuthController::class, 'login']);
            Route::post('logout', [AuthController::class, 'logout']);
            Route::get('table/{module}/{build}', [BuildController::class, 'index']);
        });
    }

    /**
     * set catch auth default guards
     *
     * @time 2021年08月17日
     * @return void
     */
    protected function setDefaultGuard()
    {
        $this->app['config']->set('auth.defaults.guard', config('catch.guard'));
    }
}
