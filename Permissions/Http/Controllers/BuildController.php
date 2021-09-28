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

use Catcher\Base\CatchResponse;
use Catcher\CatchAdmin;
use Catcher\Exceptions\FailedException;

class BuildController
{
    /**
     * index
     *
     * @time 2021年08月13日
     * @param $module
     * @param $buildName
     * @return array
     */
    public function index($module, $buildName): array
    {
        $builder = CatchAdmin::getModuleNamespace($module) . 'Build\\' . ucfirst($buildName);

        if (! class_exists($builder)) {
            throw new FailedException(sprintf('Builder [%s] Not Found', $builder));
        }

        return CatchResponse::success(app($builder)());
    }
}
