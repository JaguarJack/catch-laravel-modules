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
use CatchAdmin\Permissions\Models\Users;

class UserSeeder extends Seeder
{

    /**
     *
     * @time 2021/09/22 06:29
     * @return mixed
     */
    public function run()
    {
        $user = new Users;

        $user->username = 'admin';
        $user->password = 'catchadmin';
        $user->email = 'catch@admin.com';
        $user->creator_id = 1;

        $user->save();

        $user->roles()->attach(1);
    }
}
