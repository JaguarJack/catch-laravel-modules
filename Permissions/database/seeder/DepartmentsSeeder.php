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
use CatchAdmin\Permissions\Models\Departments;

class DepartmentsSeeder extends Seeder
{

    /**
     *
     * @time 2021/09/22 06:37
     * @return mixed
     */
    public function run()
    {
        $departments = [
            [
                'department_name' => '总部',
                'parent_id' => 0,
            ],
            [
                'department_name' => '北京总部',
                'parent_id' => 1,
            ],
            [
                'department_name' => '南京总部',
                'parent_id' => 1,
            ]
        ];

        $departmentModel = new Departments;

        foreach ($departments as $department) {
            $departmentModel->storeBy($department);
        }
    }
}
