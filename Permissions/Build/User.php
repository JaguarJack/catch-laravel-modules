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
use CatchAdmin\Permissions\Models\Jobs;
use CatchAdmin\Permissions\Models\Roles;
use Catcher\Support\CatchBuilder;
use Catcher\Support\Form\CatchForm as Form;
use Catcher\Support\Form\Fields\Relation\BelongsToManyTree;
use Catcher\Support\Table\Actions;
use Catcher\Support\Table\CatchTable as Table;
use Catcher\Support\Form\Fields\Relation\BelongsToMany;
use CatchAdmin\Permissions\Models\Users as UsersModel;
use Catcher\Support\Table\Search;

class User extends CatchBuilder
{
    protected $model = UsersModel::class;

    /**
     *
     * @time 2021年08月13日
     * @return void
     */
    public function table(Table $table)
    {
        $table->headers([
            $table->id(),

            $table->header('昵称', 'username'),

            $table->header('头像','avatar')->preview(),

            $table->header('邮箱', 'email'),

            $table->status()
                ->export(function ($value){
                    return $value == UsersModel::ENABLE ? '正常' : '关闭';
                }),

            $table->hidden( '角色', 'roles')->relations('id')
                ->export(function ($value){
                    return Roles::query()->whereIn('id', $value->pluck('id'))
                            ->pluck('role_name')
                            ->implode('|');
                }),

            $table->hidden( '岗位', 'jobs')->relations('id'),

            $table->hidden('部门', 'department_id'),

            $table->operations(),
        ]);

        $table->apiRoute('users')
        ->expandAll()
        ->bind()
        ->forceUpdate()
        ->search([
            Search::like('username', '昵称'),

            Search::like('email','邮箱'),

            Search::select('status', '状态', collect([
                UsersModel::ENABLE => '开启',
                UsersModel::DISABLE => '禁用'
            ])),

            Search::hidden('department_id')
        ]);

        $table->sort(function ($query){
            return $query->orderByDesc('id');
        });

        $table->actions(function ($table){
            $table->store();
            $table->export('users');
        });
    }

    /**
     * form
     *
     * @time 2021年08月11日
     * @return array
     */
    public function fields(): array
    {
        $fields = Form::col(12, [
            Form::text('username', '昵称')->required(),

            Form::cascader('department_id', '部门')
                ->options(Departments::query()->tree('id', 'parent_id', 'department_name'))
                ->label('department_name', 'id')->checkStrictly(),

            Form::email('email', '邮箱')->required(),

            BelongsToMany::make('jobs', '岗位')
                    ->options(Jobs::query()->where('status', Jobs::ENABLE)->get(['id as value', 'job_name as label']))
                    ->filterable(),

            Form::password('password', '密码')->show()
        ]);

        $fields[] = BelongsToManyTree::make('roles', '角色')->as('role_id')
                            ->required()
                            ->checkStrictly()
                            ->label('role_name', 'id');

        return $fields;
    }
}
