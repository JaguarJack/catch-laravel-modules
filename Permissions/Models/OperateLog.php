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
 * @property $module
 * @property $operate
 * @property $route
 * @property $params
 * @property $ip
 * @property $creator_id
 * @property $method
 * @property $created_at
 */
class OperateLog extends Model
{
    use Trans, BaseOperate;

    public $table = 'operate_log';

    public $fillable = [
        //
        'id',
        // 模块名称
        'module',
        // 操作模块
        'operate',
        // 路由
        'route',
        // 参数
        'params',
        // ip
        'ip',
        // 创建人ID
        'creator_id',
        // 请求方法
        'method',
        // 登录时间
        'created_at',
    ];
}
