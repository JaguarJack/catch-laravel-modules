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

use Catcher\Support\Table\Actions;
use Catcher\Support\Table\CatchTable as Table;
use Catcher\Support\CatchBuilder;
use CatchAdmin\Permissions\Models\Jobs as JobsModel;
use Catcher\Support\Form\CatchForm as Form;
use Catcher\Support\Table\HeaderItem;
use Catcher\Support\Table\Search;

class Job extends CatchBuilder
{

    protected $model = JobsModel::class;

    /**
     *
     * @time 2021/08/19 08:08
     * @param Table $table
     * @return void
     */
    public function table(Table $table)
    {
        $table->headers([
            $table->id(),
            $table->header('岗位名称', 'job_name'),
            $table->header('编码', 'coding'),
            $table->status(),
            $table->createdAt(),
            $table->operations(),
        ]);

        $table->store()->apiRoute('jobs')
            ->search([
                Search::like('job_name', '岗位名称')
            ])->selectionChange();
    }

    /**
     *
     * @time 2021/08/19 08:08
     * @return array
     */
    public function fields() : array
    {
        return [
            Form::text('job_name', '岗位名称')->required(),

            Form::text('coding', '岗位编码'),

            Form::radio('status', '状态')->default(1)->options([
                1 => '启用',
                2 => '禁用'
            ]),

            Form::number('sort', '排序', 1)->range(1, 10000)
        ];
    }
}
