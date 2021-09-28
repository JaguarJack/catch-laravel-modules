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

use Catcher\Base\CatchModel as Model;

/**
 * @property $id
 * @property $job_name
 * @property $coding
 * @property $creator_id
 * @property $status
 * @property $sort
 * @property $description
 * @property $created_at
 * @property $updated_at
 * @property $deleted_at
 */
class Jobs extends Model
{

    public $table = 'jobs';

    public $fillable = [
        //
        'id',
        // 岗位名称
        'job_name',
        // 编码
        'coding',
        // 创建人ID
        'creator_id',
        // 1 正常 2 停用
        'status',
        // 排序字段
        'sort',
        // 描述
        'description',
        // 创建时间
        'created_at',
        // 更新时间
        'updated_at',
        // 删除状态，null 未删除 timestamp 已删除
        'deleted_at',
    ];
}
