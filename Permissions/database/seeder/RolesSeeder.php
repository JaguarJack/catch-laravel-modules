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

use Illuminate\Database\Seeder;
use CatchAdmin\Permissions\Models\Roles;

class RolesSeeder extends Seeder
{

    /**
     *
     * @time 2021/09/22 06:35
     * @return mixed
     */
    public function run()
    {
        $role = new Roles;

        $role->role_name = '超级管理员';
        $role->identify = 'admin';
        $role->description = 'super admin';
        $role->data_range = 1;
        $role->creator_id = 1;

        $role->save();
    }
}
