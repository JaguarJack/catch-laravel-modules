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

namespace CatchAdmin\Permissions\Models;

use Illuminate\Database\Eloquent\Model;
use Catcher\Traits\DB\Trans;
use Catcher\Traits\DB\BaseOperate;

/**
 * @property $id
 * @property $login_name
 * @property $login_ip
 * @property $browser
 * @property $os
 * @property $login_at
 * @property $status
 */
class LoginLog extends Model
{
    use Trans, BaseOperate;

    public $table = 'login_log';

    public $fillable = [
        //
        'id',
        // 用户名
        'login_name',
        // 登录地点ip
        'login_ip',
        // 浏览器
        'browser',
        // 操作系统
        'os',
        // 登录时间
        'login_at',
        // 1 成功 2 失败
        'status',
    ];
}
