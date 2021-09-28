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
 * @property $department_name
 * @property $parent_id
 * @property $principal
 * @property $mobile
 * @property $email
 * @property $creator_id
 * @property $status
 * @property $sort
 * @property $created_at
 * @property $updated_at
 * @property $deleted_at
 */
class Departments extends Model
{

    public $table = 'departments';

    public $fillable = [
        //
        'id',
        // 部门名称
        'department_name',
        // 父级ID
        'parent_id',
        // 负责人
        'principal',
        // 联系电话
        'mobile',
        // 联系邮箱
        'email',
        // 创建人ID
        'creator_id',
        // 1 正常 2 停用
        'status',
        // 排序字段
        'sort',
        // 创建时间
        'created_at',
        // 更新时间
        'updated_at',
        // 删除状态，null 未删除 timestamp 已删除
        'deleted_at',
    ];
}
