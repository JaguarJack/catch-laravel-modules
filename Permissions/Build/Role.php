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

namespace CatchAdmin\Permissions\Build;

use CatchAdmin\Permissions\Models\Departments;
use CatchAdmin\Permissions\Models\Permissions;
use CatchAdmin\Permissions\Models\Roles;
use Catcher\Support\CatchBuilder;
use Catcher\Support\Form\Fields\Relation\BelongsToManyTree;
use Catcher\Support\Table\Actions;
use Catcher\Support\Table\CatchTable as Table;
use Catcher\Support\Form\CatchForm as Form;
use Catcher\Support\Table\Search;

class Role extends CatchBuilder
{
    protected $model = Roles::class;

    /**
     *
     * @time 2021/08/18 10:15
     * @param Table $table
     * @return void
     */
    public function table(Table $table)
    {
        $table->headers([
            $table->header('角色名称', 'role_name'),
            $table->header('角色标识', 'identify'),
            $table->header('角色描述', 'description'),
            $table->createdAt(),
            $table->creator(),
            $table->hidden('角色权限', 'permissions')->relations('id'),
            $table->hidden('部门', 'departments')->relations('id'),
            $table->operations(),
        ], 'id', 'parent_id', 'data_range');

        $table->actions(function ($table){
            $table->store();
        })->sort(function ($query){
           return $query->orderByDesc('id');
        })->useDataRange();

        $table->apiRoute('roles');

        $table->toTreeTable()->expandAll();

        $table->forceUpdate()->bind();

        $table->search([
            Search::like('role_name', '角色名称')
        ]);

        $table->dealWithList(function ($list){
            return $list->transform(function ($item){
                $item['_permissions'] = $item['permissions'];
                unset($item['permissions']);
                return $item;
            });
        });
    }

    /**
     *
     * @time 2021/08/18 10:15
     * @return array
     */
    public function fields() : array
    {
        return [
            Form::cascader('parent_id', '上级角色', [])->options(
                Roles::get(['id', 'parent_id', 'role_name'])
            )->filterable()->label('role_name', 'id')->fullWidth(),

            Form::text('role_name', '角色名称')
                ->required(),

            Form::text('identify', '角色标识')->required(),

            Form::textarea('description', '角色描述'),

            BelongsToManyTree::make('permissions', '角色权限')
                ->data(Permissions::get(['id', 'parent_id', 'permission_name']))
                ->label('permission_name', 'id')
                ->as('_permissions')
                ->required(),

            Form::select('data_range', '数据权限')
                ->placeholder('请选择数据权限')
                ->options($this->dataRange())
                ->fullWidth()
                ->when(Roles::SELF_CHOOSE, [
                    BelongsToManyTree::make('departments', '自定义权限')
                            ->data(Departments::query()->get(['id', 'parent_id', 'department_name']))
                            ->label('department_name', 'id')
                ])
        ];
    }

    /**
     * data range options
     *
     * @time 2021年08月26日
     * @return string[]
     */
    protected function dataRange(): array
    {
        return [
            '请选择数据权限',
            '全部数据权限',
            '自定义数据权限',
            '仅本人数据权限',
            '本部门数据权限',
            '部门以及以下数据权限'
        ];
    }
}
