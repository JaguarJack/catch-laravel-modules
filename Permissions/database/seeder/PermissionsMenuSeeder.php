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

use Illuminate\Database\Seeder;
use CatchAdmin\Permissions\Models\Permissions;

class PermissionsMenuSeeder extends Seeder
{

    /**
     *
     * @time 2021/09/22 06:18
     * @return mixed
     */
    public function run()
    {
        $permissionsModel = app(Permissions::class);
        $permissionsModel->import($this->data());
    }

    /**
     *
     * @time 2021/09/22 06:18
     * @return array
     */
    public function data() : array
    {
        return [['id' => 1, 'permission_name' => '权限管理', 'parent_id' => 0, 'level' => '', 'route' => '/permissions', 'icon' => 'el-icon-cpu', 'module' => 'permissions', 'creator_id' => 1, 'permission_mark' => 'permission', 'component' => 'layout', 'redirect' => '/permissions/users', 'keepalive' => 1, 'type' => 1, 'hidden' => 1, 'sort' => 100, 'created_at' => 1587461455, 'updated_at' => 1632280164, 'children' => [
            ['id' => 2, 'permission_name' => '用户管理', 'parent_id' => 1, 'level' => '1', 'route' => '/permissions/users', 'icon' => 'el-icon-user', 'module' => 'permissions', 'creator_id' => 1, 'permission_mark' => 'user', 'component' => 'users', 'redirect' => '', 'keepalive' => 1, 'type' => 1, 'hidden' => 1, 'sort' => 13, 'created_at' => 1587461597, 'updated_at' => 1632280164, 'children' => [
                ['id' => 3, 'permission_name' => '列表', 'parent_id' => 2, 'level' => '1-2', 'route' => '', 'icon' => '', 'module' => 'permissions', 'creator_id' => 1, 'permission_mark' => 'user@index', 'component' => '', 'redirect' => '', 'keepalive' => 1, 'type' => 2, 'hidden' => 1, 'sort' => 1, 'created_at' => 1587461647, 'updated_at' => 1631582432],

                ['id' => 5, 'permission_name' => '保存', 'parent_id' => 2, 'level' => '1-2', 'route' => '', 'icon' => '', 'module' => 'permissions', 'creator_id' => 1, 'permission_mark' => 'user@store', 'component' => '', 'redirect' => '', 'keepalive' => 1, 'type' => 2, 'hidden' => 1, 'sort' => 1, 'created_at' => 1587461721, 'updated_at' => 1620798420],

                ['id' => 7, 'permission_name' => '更新', 'parent_id' => 2, 'level' => '1-2', 'route' => '', 'icon' => '', 'module' => 'permissions', 'creator_id' => 1, 'permission_mark' => 'user@update', 'component' => '', 'redirect' => '', 'keepalive' => 1, 'type' => 2, 'hidden' => 1, 'sort' => 1, 'created_at' => 1587461762, 'updated_at' => 1620798420],

                ['id' => 8, 'permission_name' => '删除', 'parent_id' => 2, 'level' => '1-2', 'route' => '', 'icon' => '', 'module' => 'permissions', 'creator_id' => 1, 'permission_mark' => 'user@delete', 'component' => '', 'redirect' => '', 'keepalive' => 1, 'type' => 2, 'hidden' => 1, 'sort' => 1, 'created_at' => 1587461841, 'updated_at' => 1620798420],

                ['id' => 9, 'permission_name' => '禁用', 'parent_id' => 2, 'level' => '1-2', 'route' => '', 'icon' => '', 'module' => 'permissions', 'creator_id' => 1, 'permission_mark' => 'user@switchStatus', 'component' => '', 'redirect' => '', 'keepalive' => 1, 'type' => 2, 'hidden' => 1, 'sort' => 1, 'created_at' => 1587461876, 'updated_at' => 1620798420],
            ]],

            ['id' => 11, 'permission_name' => '角色管理', 'parent_id' => 1, 'level' => '1', 'route' => '/permissions/roles', 'icon' => 'el-icon-s-custom', 'module' => 'permissions', 'creator_id' => 1, 'permission_mark' => 'role', 'component' => 'roles', 'redirect' => '', 'keepalive' => 1, 'type' => 1, 'hidden' => 1, 'sort' => 9, 'created_at' => 1587461939, 'updated_at' => 1632280164, 'children' => [
                ['id' => 12, 'permission_name' => '列表', 'parent_id' => 11, 'level' => '1-11', 'route' => '', 'icon' => '', 'module' => 'permissions', 'creator_id' => 1, 'permission_mark' => 'role@index', 'component' => '', 'redirect' => '', 'keepalive' => 1, 'type' => 2, 'hidden' => 1, 'sort' => 1, 'created_at' => 1587461984, 'updated_at' => 1617530154],

                ['id' => 14, 'permission_name' => '保存', 'parent_id' => 11, 'level' => '1-11', 'route' => '', 'icon' => '', 'module' => 'permissions', 'creator_id' => 1, 'permission_mark' => 'role@store', 'component' => '', 'redirect' => '', 'keepalive' => 1, 'type' => 2, 'hidden' => 1, 'sort' => 1, 'created_at' => 1587462021, 'updated_at' => 1617530154],

                ['id' => 16, 'permission_name' => '更新', 'parent_id' => 11, 'level' => '1-11', 'route' => '', 'icon' => '', 'module' => 'permissions', 'creator_id' => 1, 'permission_mark' => 'role@update', 'component' => '', 'redirect' => '', 'keepalive' => 1, 'type' => 2, 'hidden' => 1, 'sort' => 1, 'created_at' => 1587462058, 'updated_at' => 1617530154],

                ['id' => 17, 'permission_name' => '删除', 'parent_id' => 11, 'level' => '1-11', 'route' => '', 'icon' => '', 'module' => 'permissions', 'creator_id' => 1, 'permission_mark' => 'role@delete', 'component' => '', 'redirect' => '', 'keepalive' => 1, 'type' => 2, 'hidden' => 1, 'sort' => 1, 'created_at' => 1587462070, 'updated_at' => 1617530154],

                ['id' => 18, 'permission_name' => '权限获取', 'parent_id' => 11, 'level' => '1-11', 'route' => '', 'icon' => '', 'module' => 'permissions', 'creator_id' => 1, 'permission_mark' => 'role@getPermissions', 'component' => '', 'redirect' => '', 'keepalive' => 1, 'type' => 2, 'hidden' => 1, 'sort' => 1, 'created_at' => 1587462094, 'updated_at' => 1617530154],
            ]],

            ['id' => 19, 'permission_name' => '菜单管理', 'parent_id' => 1, 'level' => '1', 'route' => '/permissions/rules', 'icon' => 'el-icon-collection-tag', 'module' => 'permissions', 'creator_id' => 1, 'permission_mark' => 'permission', 'component' => 'rules', 'redirect' => '', 'keepalive' => 1, 'type' => 1, 'hidden' => 1, 'sort' => 12, 'created_at' => 1587462147, 'updated_at' => 1632280164, 'children' => [
                ['id' => 20, 'permission_name' => '列表', 'parent_id' => 19, 'level' => '1-19', 'route' => '', 'icon' => '', 'module' => 'permissions', 'creator_id' => 1, 'permission_mark' => 'permission@index', 'component' => '', 'redirect' => '', 'keepalive' => 1, 'type' => 2, 'hidden' => 1, 'sort' => 1, 'created_at' => 1587462205, 'updated_at' => 1617181125],

                ['id' => 22, 'permission_name' => '保存', 'parent_id' => 19, 'level' => '1-19', 'route' => '', 'icon' => '', 'module' => 'permissions', 'creator_id' => 1, 'permission_mark' => 'permission@store', 'component' => '', 'redirect' => '', 'keepalive' => 1, 'type' => 2, 'hidden' => 1, 'sort' => 1, 'created_at' => 1587462250, 'updated_at' => 1617181125],

                ['id' => 23, 'permission_name' => '禁用/启用', 'parent_id' => 19, 'level' => '1-19', 'route' => '', 'icon' => '', 'module' => 'permissions', 'creator_id' => 1, 'permission_mark' => 'permission@show', 'component' => '', 'redirect' => '', 'keepalive' => 1, 'type' => 2, 'hidden' => 1, 'sort' => 1, 'created_at' => 1587462273, 'updated_at' => 1617181125],

                ['id' => 24, 'permission_name' => '更新', 'parent_id' => 19, 'level' => '1-19', 'route' => '', 'icon' => '', 'module' => 'permissions', 'creator_id' => 1, 'permission_mark' => 'permission@update', 'component' => '', 'redirect' => '', 'keepalive' => 1, 'type' => 2, 'hidden' => 1, 'sort' => 1, 'created_at' => 1587462284, 'updated_at' => 1617181125],

                ['id' => 25, 'permission_name' => '删除', 'parent_id' => 19, 'level' => '1-19', 'route' => '', 'icon' => '', 'module' => 'permissions', 'creator_id' => 1, 'permission_mark' => 'permission@delete', 'component' => '', 'redirect' => '', 'keepalive' => 1, 'type' => 2, 'hidden' => 1, 'sort' => 1, 'created_at' => 1587462296, 'updated_at' => 1617181125],
            ]],

            ['id' => 27, 'permission_name' => '部门管理', 'parent_id' => 1, 'level' => '1', 'route' => '/permissions/departments', 'icon' => 'el-icon-monitor', 'module' => 'permissions', 'creator_id' => 1, 'permission_mark' => 'department', 'component' => 'departments', 'redirect' => '', 'keepalive' => 1, 'type' => 1, 'hidden' => 1, 'sort' => 7, 'created_at' => 1587462488, 'updated_at' => 1632280164, 'children' => [
                ['id' => 28, 'permission_name' => '列表', 'parent_id' => 27, 'level' => '1-27', 'route' => '', 'icon' => '', 'module' => 'permissions', 'creator_id' => 1, 'permission_mark' => 'department@index', 'component' => '', 'redirect' => '', 'keepalive' => 1, 'type' => 2, 'hidden' => 1, 'sort' => 1, 'created_at' => 1587462529, 'updated_at' => 1599030565],

                ['id' => 29, 'permission_name' => '保存', 'parent_id' => 27, 'level' => '1-27', 'route' => '', 'icon' => '', 'module' => 'permissions', 'creator_id' => 1, 'permission_mark' => 'department@store', 'component' => '', 'redirect' => '', 'keepalive' => 1, 'type' => 2, 'hidden' => 1, 'sort' => 1, 'created_at' => 1587462548, 'updated_at' => 1599030565],

                ['id' => 30, 'permission_name' => '更新', 'parent_id' => 27, 'level' => '1-27', 'route' => '', 'icon' => '', 'module' => 'permissions', 'creator_id' => 1, 'permission_mark' => 'department@update', 'component' => '', 'redirect' => '', 'keepalive' => 1, 'type' => 2, 'hidden' => 1, 'sort' => 1, 'created_at' => 1587462579, 'updated_at' => 1599030565],

                ['id' => 31, 'permission_name' => '删除', 'parent_id' => 27, 'level' => '1-27', 'route' => '', 'icon' => '', 'module' => 'permissions', 'creator_id' => 1, 'permission_mark' => 'department@delete', 'component' => '', 'redirect' => '', 'keepalive' => 1, 'type' => 2, 'hidden' => 1, 'sort' => 1, 'created_at' => 1587462592, 'updated_at' => 1599030565],
            ]],

            ['id' => 32, 'permission_name' => '岗位管理', 'parent_id' => 1, 'level' => '1', 'route' => '/permissions/jobs', 'icon' => 'el-icon-setting', 'module' => 'permissions', 'creator_id' => 1, 'permission_mark' => 'job', 'component' => 'jobs', 'redirect' => '', 'keepalive' => 1, 'type' => 1, 'hidden' => 1, 'sort' => 1, 'created_at' => 1587462707, 'updated_at' => 1632280164, 'children' => [
                ['id' => 33, 'permission_name' => '列表', 'parent_id' => 32, 'level' => '1-32', 'route' => '', 'icon' => '', 'module' => 'permissions', 'creator_id' => 1, 'permission_mark' => 'job@indexs', 'component' => '', 'redirect' => '', 'keepalive' => 1, 'type' => 2, 'hidden' => 1, 'sort' => 1, 'created_at' => 1587462757, 'updated_at' => 1598959522],

                ['id' => 34, 'permission_name' => '保存', 'parent_id' => 32, 'level' => '1-32', 'route' => '', 'icon' => '', 'module' => 'permissions', 'creator_id' => 1, 'permission_mark' => 'job@store', 'component' => '', 'redirect' => '', 'keepalive' => 1, 'type' => 2, 'hidden' => 1, 'sort' => 1, 'created_at' => 1587462774, 'updated_at' => 1598959522],

                ['id' => 35, 'permission_name' => '更新', 'parent_id' => 32, 'level' => '1-32', 'route' => '', 'icon' => '', 'module' => 'permissions', 'creator_id' => 1, 'permission_mark' => 'job@update', 'component' => '', 'redirect' => '', 'keepalive' => 1, 'type' => 2, 'hidden' => 1, 'sort' => 1, 'created_at' => 1587462785, 'updated_at' => 1598959522],

                ['id' => 36, 'permission_name' => '删除', 'parent_id' => 32, 'level' => '1-32', 'route' => '', 'icon' => '', 'module' => 'permissions', 'creator_id' => 1, 'permission_mark' => 'job@delete', 'component' => '', 'redirect' => '', 'keepalive' => 1, 'type' => 2, 'hidden' => 1, 'sort' => 1, 'created_at' => 1587462794, 'updated_at' => 1598959522],

                ['id' => 37, 'permission_name' => '获取全部', 'parent_id' => 32, 'level' => '1-32', 'route' => '', 'icon' => '', 'module' => 'permissions', 'creator_id' => 1, 'permission_mark' => 'job@getAll', 'component' => '', 'redirect' => '', 'keepalive' => 1, 'type' => 2, 'hidden' => 1, 'sort' => 1, 'created_at' => 1587462818, 'updated_at' => 1598959522],
            ]],
        ]]];
    }
}
