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
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property $id
 * @property $role_name
 * @property $identify
 * @property $parent_id
 * @property $description
 * @property $data_range
 * @property $creator_id
 * @property $created_at
 * @property $updated_at
 * @property $deleted_at
 */
class Roles extends Model
{
    use DataRangeScopeTrait;

    public $table = 'roles';

    public $fillable = [
        //
        'id',
        // 角色名
        'role_name',
        // 角色的标识，用英文表示，用于后台路由权限
        'identify',
        // 父级ID
        'parent_id',
        // 角色备注
        'description',
        // 1 全部数据 2 自定义数据 3 仅本人数据 4 部门数据 5 部门及以下数据
        'data_range',
        // 创建人ID
        'creator_id',
        // 创建时间
        'created_at',
        // 更新时间
        'updated_at',
        // 删除状态，0未删除 >0 已删除
        'deleted_at',
    ];

    public const ALL_DATA = 1; // 全部数据
    public const SELF_CHOOSE = 2; // 自定义数据
    public const SELF_DATA = 3; // 本人数据
    public const DEPARTMENT_DATA = 4; // 部门数据
    public const DEPARTMENT_DOWN_DATA = 5; // 部门及以下数据

    /**
     * role's permissions
     *
     * @time 2021年08月17日
     * @return BelongsToMany
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permissions::class, 'role_has_permissions', 'role_id', 'permission_id');
    }

    /**
     * role's departments
     *
     * @time 2021年09月27日
     * @return BelongsToMany
     */
    public function departments(): BelongsToMany
    {
        return $this->belongsToMany(Departments::class, 'role_has_departments', 'role_id', 'department_id');
    }
}
