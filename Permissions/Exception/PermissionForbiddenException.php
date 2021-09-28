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

namespace CatchAdmin\Permissions\Exception;

use Catcher\Exceptions\CatchException;
use Catcher\Support\Code;

class PermissionForbiddenException extends CatchException
{
    protected $code = Code::PERMISSION_FORBIDDEN;

    protected $message = 'Permission Forbidden';
}
