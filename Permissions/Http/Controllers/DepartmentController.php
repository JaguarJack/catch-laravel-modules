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

use Catcher\Base\CatchController;
use CatchAdmin\Permissions\Build\Department;

class DepartmentController extends CatchController
{

    /**
     *
     * @time 2021/08/18 09:52
     * @param Department $builder
     * @return mixed
     */
    public function __construct(Department $builder)
    {
        $this->builder = $builder;
        parent::__construct();
    }
}
