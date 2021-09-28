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
 * @property $permission_name
 * @property $parent_id
 * @property $level
 * @property $route
 * @property $icon
 * @property $module
 * @property $creator_id
 * @property $permission_mark
 * @property $component
 * @property $redirect
 * @property $keepalive
 * @property $type
 * @property $hidden
 * @property $sort
 * @property $created_at
 * @property $updated_at
 * @property $deleted_at
 */
class Permissions extends Model
{
    public $table = 'permissions';

    public $fillable = [
        //
        'id',
        // 菜单名称
        'permission_name',
        // 父级ID
        'parent_id',
        // 层级
        'level',
        // 路由
        'route',
        // 菜单图标
        'icon',
        // 模块
        'module',
        // 创建人ID
        'creator_id',
        // 权限标识
        'permission_mark',
        // 组件名称
        'component',
        // 跳转地址
        'redirect',
        // 1 缓存 2 不存在
        'keepalive',
        // 1 菜单 2 按钮
        'type',
        //
        'hidden',
        // 排序字段
        'sort',
        // 创建时间
        'created_at',
        // 更新时间
        'updated_at',
        // 删除状态，null 未删除 timestamp 已删除
        'deleted_at',
    ];

    public const MENU_TYPE = 1;
    public const BTN_TYPE = 2;


    /**
     * 导入数据
     *
     * @time 2021年09月22日
     * @param array $data
     * @param string $pid
     * @return void
     */
    public function import(array $data, string $pid = 'parent_id')
    {
        foreach ($data as $value) {
            if (isset($value[$this->primaryKey])) {
                unset($value[$this->primaryKey]);
            }

            $children = $value['children'] ?? false;

            if($children) {
                unset($value['children']);
            }
            // 首先查询是否存在
            $menu = self::query()
                        ->where('permission_name', $value['permission_name'])
                        ->where('module', $value['module'])
                        ->where('permission_mark', $value['permission_mark'])
                        ->first();

            $id = $menu ? $menu->id : Permissions::query()->insertGetId($value);

            if ($children) {
                foreach ($children as &$v) {
                    $v[$pid] = $id;

                    $v['level'] = ! $value[$pid] ? $id : sprintf('%s-%s', $value['level'], $id);
                }

                self::import($children, $pid);
            }
        }
    }
}
