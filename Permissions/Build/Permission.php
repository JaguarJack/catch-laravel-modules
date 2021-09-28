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

use Catcher\Facade\Module;
use Catcher\Support\Table\Actions;
use Catcher\Support\Table\CatchTable as Table;
use Catcher\Support\CatchBuilder;
use CatchAdmin\Permissions\Models\Permissions as PermissionsModel;
use Catcher\Support\Form\CatchForm as Form;
use Catcher\Support\Table\Search;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Str;

class Permission extends CatchBuilder
{
    protected $model = PermissionsModel::class;

    /**
     *
     * @time 2021/08/26 05:42
     * @param Table $table
     * @return mixed
     */
    public function table(Table $table)
    {
        $table->headers([
            $table->header('菜单名称', 'permission_name'),

            $table->header('路由Path', 'route'),

            $table->header('权限标识', 'actionList')->ignore()->component('actions', 'actionList'),

            $table->status(true, 'hidden'),

            $table->createdAt(),

            $table->operations(),

        ], 'parent_id', 'id', 'permission_mark', 'module', 'component', 'icon', 'keepalive', 'redirect');

        $table->where(function ($model) {
            return $model->where('type', PermissionsModel::MENU_TYPE);
        });


        $table->apiRoute('permissions')
            ->search([
                Search::like('permission_name', '菜单名称'),
                Search::hidden('actionList', 'actionList'),
            ])
            ->defaultQueryParams(['actionList'])
            ->actions(function ($table){
                $table->store();
            })
            ->toTreeTable();

        // 要做转换
        $table->dealWithList(function ($permissions) {
            // 获取按钮类型并且重新排列
            $buttonList = [];
            PermissionsModel::query()
                ->whereIn('parent_id', $permissions->pluck('id')->unique())
                ->where('type', PermissionsModel::BTN_TYPE)
                ->get()
                ->each(function ($item) use (&$buttonList) {
                    $buttonList[$item['parent_id']][] = $item->toArray();
                });

            // 子节点的 key
            $children = request()->get('actionList') ?? 'children';

            // 处理
            return $permissions->transform(function ($item) use ($buttonList, $children) {
                $item[$children] = $buttonList[$item['id']] ?? [];
                return $item;
            });
        });
    }

    /**
     *
     * @time 2021/08/26 05:42
     * @return array
     */
    public function fields(): array
    {
        return Form::col(12, [
            Form::cascader('parent_id', '父级菜单')
                ->options(PermissionsModel::query()->where('type', PermissionsModel::MENU_TYPE)->get(['id', 'permission_name', 'parent_id']))
                ->label('permission_name', 'id')
                ->checkStrictly()->filterable()->fullWidth(),

            Form::radio('type', '菜单类型')->asButton()
                ->default(PermissionsModel::MENU_TYPE)
                ->options([
                    PermissionsModel::MENU_TYPE => '菜单',
                    PermissionsModel::BTN_TYPE => '按钮',
                ])
                ->when(PermissionsModel::MENU_TYPE,
                    Form::col(12, [
                        Form::text('permission_name', '菜单名称')->required(),
                        Form::text('permission_mark', '权限标识')->required(),

                        Form::select('module', '模块')
                            ->options($this->getModules())
                            ->required()->fullWidth()->allowCreate()->filterable(),

                        Form::text('icon', '菜单图标')->fullWidth(),

                        Form::text('route', '菜单Path'),

                        Form::cascader('component', '组件')
                            ->options([])
                            ->fullWidth()
                            ->showAllLevels(false),

                        Form::text('redirect', 'Redirect'),

                        Form::number('sort', '排序')->value(1),

                        Form::radio('keepalive', 'Keepalive')
                            ->value(1)
                            ->options([1 => '启用', 2 => '禁用']),

                        Form::radio('hidden', 'Hidden')->value(1)->options([1 => '显示', 2 => '隐藏']),

                        Form::radio('restful', 'Restful 路由')->value(0)->options(['不生成', '生成'])
                    ])
                )->when(PermissionsModel::BTN_TYPE,
                    Form::col(12, [
                        Form::select('permission_name', '菜单名称')
                            ->allowCreate()
                            ->options([
                                '列表' => '列表',
                                '新增' => '新增',
                                '读取' => '读取',
                                '更新' => '更新',
                                '删除' => '删除',
                                '禁用/启用' => '禁用/启用',
                                '导出' => '导出',
                                '导入' => '导入'
                            ])
                            ->required()->fullWidth(),

                        Form::select('permission_mark', '权限标识')
                            ->allowCreate()
                            ->options([
                                'index' => 'index',
                                'store' => 'store',
                                'show' => 'show',
                                'update' => 'update',
                                'destroy' => 'destroy',
                                'disable' => 'disable',
                                'export' => 'export',
                                'import' => 'import',
                            ])
                            ->required(),

                        Form::number('sort', '排序')->value(1),
                    ])
                )
        ]);

    }


    /**
     * get modules
     *
     * @time 2021年08月26日
     * @return array
     */
    protected function getModules(): array
    {
        $modules = [];

        foreach (Module::all() as $module) {
            if ($module['enable']) {
                $modules[] = [
                    $module['name'],
                    $module['title']
                ];
            }
        }

        return $modules;
    }

    /**
     * before save
     *
     * @time 2021年09月17日
     * @param Form $form
     * @return void
     */
    public function beforeSave(Form $form)
    {
        // 如果是子分类 自动写入父类模块
        $parentId = $params['parent_id'] ?? 0;
        // 按钮类型寻找上级
        if ($form['type'] == PermissionsModel::BTN_TYPE && $parentId) {
            $permissionMark = $form['permission_mark'];
            // 查找父级
            /* @var  PermissionsModel $parentPermission */
            $parentPermission = PermissionsModel::query()->find($parentId);
            // 如果父级是顶级 parent_id = 0
            if ($parentPermission->parent_id) {
                if (Str::contains($parentPermission->permission_mark, '@')) {
                    list($controller, $action) = explode('@', $parentPermission->permission_mark);
                    $permissionMark = $controller . '@' . $permissionMark;
                } else {
                    $permissionMark = $parentPermission->permission_mark . '@' . $permissionMark;
                }
            }

            $form['permission_mark'] = $permissionMark;
            $form['module'] = $parentPermission->module;
        }

    }


    /**
     * after save
     *
     * @time 2021年09月17日
     * @param Form $form
     * @throws BindingResolutionException
     * @return void
     */
    protected function afterSave(Form $form)
    {
        $restful = intval(isset($form->restful) ?? 0);
        /* @var PermissionsModel $model */
        $model = $form->getModel();

        if ($model->parent_id) {
            /* @var PermissionsModel $parent */
            $parent = PermissionsModel::query()->where('id', $model->parent_id)->first();

            $level = $parent->level ? $parent->level . '-' . $parent->id : $parent->id;

            if ($restful) {
                $this->createRestful($model, $level);
            }

            PermissionsModel::query()->where('id', $model->id)->update([
                'level' => $level
            ]);
        }
    }

    /**
     * create restful
     *
     * @time 2021年09月23日
     * @param PermissionsModel $model
     * @param $level
     * @return void
     */
    protected function createRestful(PermissionsModel $model, $level)
    {
            foreach ([
                     'index' => '列表',
                     'store' => '保存',
                     'update' => '更新',
                     'delete' => '删除',
            ] as $k => $r) {
                PermissionsModel::query()->insert([
                    'parent_id' => $model->id,
                    'permission_name' => $r,
                    'level' => $level . '-' . $model->id,
                    'module' => $model->module,
                    'creator_id' => $model->creator_id,
                    'permission_mark' => $model->permission_mark . '@' . $k,
                    'type' => PermissionsModel::BTN_TYPE,
                    'created_at' => time(),
                    'updated_at' => time(),
                    'sort' => 1,
                ]);
        }
    }

    /**
     * 更新前
     *
     * @time 2021年09月13日
     * @param Form $form
     * @return void
     * @throws BindingResolutionException
     */
    protected function beforeUpdate(Form $form)
    {
        /* @var PermissionsModel $permission */
        $permission = PermissionsModel::query()->find($form->getPrimaryKeyValue());

        $form['parent_id'] = $permission->parent_id;
        $form['level'] = $permission->level;

        // 按钮类型
        if (isset($form['type']) && $form['type'] == PermissionsModel::BTN_TYPE && $permission->parent_id) {
            /* @var  PermissionsModel $parentPermission */
            $parentPermission = PermissionsModel::query()->find($permission->parent_id);
            $permissionMark = $form['permission_mark'];

            if ($parentPermission->parent_id) {
                if (Str::contains($parentPermission->permission_mark, '@')) {
                    list($controller, $action) = explode('@', $parentPermission->permission_mark);
                    $permissionMark = $controller . '@' . $permissionMark;
                } else {
                    $permissionMark = $parentPermission->permission_mark . '@' . $permissionMark;
                }
            }

            $form['permission_mark'] = $permissionMark;
            $form['updated_at'] = time();
        }
    }

    /**
     * 更新后
     *
     * @time 2021年09月13日
     * @param Form $form
     * @return void
     * @throws BindingResolutionException
     */
    protected function afterUpdate(Form $form)
    {
        $primaryKey = $form->getModel()->getKeyName();

        $params = $form->getCondition();

        // 更新 hidden
        if (isset($form->hidden)) {
            $form->getModel()
                ->where('parent_id', $params[$primaryKey])
                ->update([
                    'hidden' => $form->hidden
                ]);
        }

        // 更新 module
        if (isset($form->module)) {
            $form->getModel()
                ->where('parent_id', $params[$primaryKey])
                ->update([
                    'module' => $form->module
                ]);
        }
    }
}
