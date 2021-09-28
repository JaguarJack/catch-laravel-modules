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
use CatchAdmin\Permissions\Build\Job;

class JobController extends CatchController
{

    /**
     *
     * @time 2021/08/19 08:08
     * @param Job $builder
     * @return void
     */
    public function __construct(Job $builder)
    {
        $this->builder = $builder;
        parent::__construct();
    }
}
