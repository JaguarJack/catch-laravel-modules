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

namespace CatchAdmin\Permissions\Http\Middleware;

use CatchAdmin\Permissions\Exception\PermissionForbiddenException;
use CatchAdmin\Permissions\Models\Users;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Request as RequestAlias;
use CatchAdmin\Permissions\Models\Permissions as PermissionsModel;

class Permissions
{
    /**
     * handle
     *
     * @time 2021年08月14日
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        /* @var Users $user */
        $user = Auth::user();

        if ($request->method() == RequestAlias::METHOD_GET || $user->isSuperAdmin()) {
            return $next($request);
        }

        [$module, $mark] = $this->parseActionName($request->route()->getActionName());

        $permissionId = PermissionsModel::query()->where('module', $module)->where('permission_mark', $mark)->value('id');

        if (! $permissionId || ! $user->hasPermission($permissionId)) {
            throw new PermissionForbiddenException();
        }

        // request store current permission id
        $request['permission_id'] = $permissionId;

        return $next($request);
    }

    /**
     *
     * @time 2021年08月14日
     * @param $actionName
     * @return array
     */
    protected function parseActionName($actionName): array
    {
        [$controller, $action] = explode('@', $actionName);

        $controller = explode('\\',
            Str::replace(config('catch.module.namespace') . '\\', '', $controller));

        return [
            // get module name
            lcfirst(array_shift($controller)),
            // Controller name & action name
            lcfirst(Str::replace('Controller', '', array_pop($controller))) .'@'. $action
        ];
    }
}
