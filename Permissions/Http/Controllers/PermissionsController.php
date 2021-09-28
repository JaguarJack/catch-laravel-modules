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
use CatchAdmin\Permissions\Build\Permission;

class PermissionsController extends CatchController
{

    /**
     *
     * @time 2021/08/26 05:42
     * @param Permission $builder
     * @return mixed
     */
    public function __construct(Permission $builder)
    {
        $this->builder = $builder;
        parent::__construct();
    }
}
