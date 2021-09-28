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

namespace CatchAdmin\Permissions\Http\Controllers;

use CatchAdmin\Permissions\Models\Roles;
use Catcher\Base\CatchController;
use CatchAdmin\Permissions\Build\Role;
use Catcher\Base\CatchResponse;
use CatchAdmin\Permissions\Models\Permissions;

class RoleController extends CatchController
{
    /**
     *
     * @time 2021/08/19 06:20
     * @param Role $builder
     * @return void
     */
    public function __construct(Role $builder)
    {
        $this->builder = $builder;
        parent::__construct();
    }

    /**
     *
     * @time 2021年09月26日
     * @param $id
     * @return array
     */
    public function permissions($id): array
    {
        $permissions = Roles::query()->where('id', $id)
                                ->first()
                                ->permissions()
                                ->select(['permissions.id', 'parent_id', 'permission_name'])
                                ->get();

        $permissions = $permissions->count() ? $permissions : Permissions::query()->get(['id', 'parent_id', 'permission_name']);

        return CatchResponse::success($permissions->toTree());
    }

}
