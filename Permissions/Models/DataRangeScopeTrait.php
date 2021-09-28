<?php
// +----------------------------------------------------------------------
// | CatchAdmin [Just Like ～ ]
// +----------------------------------------------------------------------
// | Copyright (c) 2017~{$year} http://catchadmin.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( https://github.com/yanwenwu/catch-admin/blob/master/LICENSE.txt )
// +----------------------------------------------------------------------
// | Author: JaguarJack [ njphper@gmail.com ]
// +----------------------------------------------------------------------


namespace CatchAdmin\Permissions\Models;

use Illuminate\Support\Facades\Auth;

trait DataRangeScopeTrait
{
    public function scopeDataRange($query)
    {
        /* @var Users $user */
        $user = Auth::user();

        // 用户不存在 || 用户是超级管理员 || 当前数据表没有 creator_id 字段
        if (! $user || $user->isSuperAdmin() || ! in_array('creator_id', $this->getFillable())) {
            return $query;
        }

        /* @var Roles[] $roles */
        $roles = $user->roles()->get();

        $isAll = false;
        $userIds = [];

        foreach ($roles as $role) {
            switch ($role->data_range) {
                case Roles::ALL_DATA: // 所有数据
                    $isAll = true;
                    break;
                case Roles::SELF_CHOOSE: // 自定义数据
                    $userIds = array_merge($userIds, $this->getUserIdsByDepartmentIds($role->departments()->select(['id'])->pluck('id')));
                    break;
                case Roles::DEPARTMENT_DOWN_DATA: // 部门及以下
                    $departmentIds = Departments::query()->where('parent_id', $user->department_id)->pluck('id');
                    $departmentIds[] = $user->department_id;
                    $userIds = array_merge([ $user->id ], $this->getUserIdsByDepartmentIds($departmentIds));
                    break;
                case Roles::SELF_DATA: // 本人数据
                    $userIds = [ $user->id ];
                    break;
                case Roles::DEPARTMENT_DATA: // 部门数据
                    $userIds = array_merge($userIds, $this->getUserIdsByDepartmentIds([$user->department_id]));
                    break;
            }

            if ($isAll) { break; }
        }

        return count($userIds) ? $query->whereIn($this->getTable() . '.creator_id', $userIds) : $query;
    }


    /**
     *
     * @time 2021年09月27日
     * @param $departmentIds
     * @return array
     */
    protected function getUserIdsByDepartmentIds($departmentIds): array
    {
        return Users::query()->whereIn('department_id', $departmentIds)
            ->pluck('id')->toArray();
    }
}
