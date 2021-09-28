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
use CatchAdmin\Permissions\Build\User;
use Catcher\Base\CatchResponse;

class UserController extends CatchController
{
    public function __construct(User $build)
    {
        $this->builder = $build;

        parent::__construct();
    }

    /**
     * 导出
     *
     * @time 2021年09月18日
     * @return array
     */
    public function export()
    {
        return CatchResponse::success($this->builder->export());
    }
}
