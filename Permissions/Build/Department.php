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

use Catcher\Support\CatchBuilder;
use Catcher\Support\Table\CatchTable as Table;
use CatchAdmin\Permissions\Models\Departments as DepartmentModel;
use Catcher\Support\Form\CatchForm as Form;
use Catcher\Support\Table\Search;

class Department extends CatchBuilder
{
    protected $model = DepartmentModel::class;

    /**
     *
     * @time 2021/08/18 09:52
     * @param Table $table
     * @return void
     */
    public function table(Table $table)
    {
        $table->headers([
            $table->header('部门名称', 'department_name'),

            $table->sorts(),

            $table->status(),

            $table->createdAt(),

            $table->operations(),
        ], 'id', 'parent_id', 'principal', 'mobile', 'email')
        ->apiRoute('departments')
        ->expandAll()
        ->store()
        ->dialogWidth('35%')
        ->toTreeTable()
        ->search([
            Search::like('department_name', '部门名称'),
            Search::select('status', '状态', [
                DepartmentModel::ENABLE => '开启',
                DepartmentModel::DISABLE => '关闭'
            ])
        ]);
    }

    /**
     *
     * @time 2021/08/18 09:52
     * @return array
     */
    public function fields() : array
    {
        return [
            Form::cascader('parent_id', '上级部门')->value([0])
                ->options(DepartmentModel::query()->get(['id', 'parent_id', 'department_name']))
                ->label('department_name', 'id')->checkStrictly()
                ->fullWidth(),

            Form::text('department_name', '部门名称')->required(),

            Form::text('principal', '部门负责人'),

            Form::text('mobile', '负责人联系方式'),

            Form::email('email', '邮箱'),

            Form::number('sort', '排序')->default(1)->min(1)->max(10000),
        ];
    }
}
