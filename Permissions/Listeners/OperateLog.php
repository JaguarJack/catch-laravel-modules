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

namespace CatchAdmin\Permissions\Listeners;

use CatchAdmin\Permissions\Models\Permissions;
use Illuminate\Support\Facades\Auth;
use CatchAdmin\Permissions\Models\OperateLog as OperateLogModel;
use CatchAdmin\Permissions\Events\OperateLog as Event;

class OperateLog
{
    public function handle(Event $event)
    {
        if ($creatorId = Auth::id()) {
            /* @var Permissions $permission */
            $permission = Permissions::query()->findOrFail($event->permissionId);

            $parentModuleName = Permissions::query()->where('id', $permission->parent_id)->value('permission_name');

            $params = \json_encode(request()->except('permission_id'), JSON_UNESCAPED_UNICODE);

            OperateLogModel::query()->insert([
                'creator_id' => $creatorId,
                'module'     => $parentModuleName ? : '',
                'method'     => request()->method(),
                'operate'    => $permission->permission_name,
                'route'      => $permission->permission_mark,
                'params'     => $params <= 1000 ? $params : '',
                'created_at' => time(),
                'ip'         => request()->ip()
            ]);
        }
    }
}
