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

use Catcher\Support\DB\SoftDelete;
use Catcher\Traits\DB\BaseOperate;
use Catcher\Traits\DB\Trans;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 *
 * @property $id
 * @property $username
 * @property $password
 * @property $email
 * @property $avatar
 * @property $remember_token
 * @property $creator_id
 * @property $department_id
 * @property $status
 * @property $last_login_ip
 * @property $last_login_time
 * @property $created_at
 * @property $updated_at
 * @property $deleted_at
 */
class Users extends Authenticatable implements JWTSubject
{
    use SoftDeletes, BaseOperate, Trans;

    use DataRangeScopeTrait;

    public $table = 'users';

    public $fillable = [
        //
        'id',
        // 用户名
        'username',
        // 用户密码
        'password',
        // 邮箱 登录
        'email',
        // 用户头像
        'avatar',
        // 用户token
        'remember_token',
        // 创建人ID
        'creator_id',
        // 部门ID
        'department_id',
        // 用户状态 1 正常 2 禁用
        'status',
        // 最后登录IP
        'last_login_ip',
        // 最后登录时间
        'last_login_time',
        // 创建时间
        'created_at',
        // 更新时间
        'updated_at',
        // 删除状态，0未删除 >0 已删除
        'deleted_at',
    ];

    /**
     * unix timestamp
     *
     * @var string
     */
    protected $dateFormat = 'U';

    /**
     * paginate limit
     */
    protected $perPage = 10;

    /**
     * @var string[]
     */
    protected $hidden = ['deleted_at', 'remember_token'];

    /**
     * @var string[]
     */
    protected $casts = [
        'created_at' => 'timestamp',

        'updated_at' => 'timestamp',

        'deleted_at' => 'timestamp'
    ];

    const ENABLE = 1;
    const DISABLE = 2;

    /**
     *
     * @time 2021年08月10日
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     *
     * @time 2021年08月10日
     * @return array
     */
    public function getJWTCustomClaims(): array
    {
        return [];
    }

    /**
     *
     * @time 2021年08月10日
     * @return void
     */
    public static function bootSoftDeletes()
    {
        static::addGlobalScope(new SoftDelete);
    }

    /**
     * bcrypt password
     *
     * @time 2021年09月22日
     * @param $value
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    /**
     * user's Roles
     *
     * @time 2021年08月13日
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Roles::class, 'user_has_roles', 'uid', 'role_id');
    }

    /**
     * user's Jobs
     *
     * @time 2021年08月14日
     * @return BelongsToMany
     */
    public function jobs(): BelongsToMany
    {
        return $this->belongsToMany(Jobs::class, 'user_has_jobs', 'uid', 'job_id');
    }

    /**
     * user is super admin
     *
     * @time 2021年08月14日
     * @return bool
     */
    public function isSuperAdmin(): bool
    {
        return $this->{$this->getKeyName()} == config('catch.super_admin');
    }

    /**
     * user's permissions
     *
     * @time 2021年08月14日
     * @return array|mixed
     */
    public function permissions($asTree = false)
    {
        $permissions = [];

        $fields = [
            'id', 'parent_id', 'route', 'permission_name as title', 'icon', 'component', 'redirect',
            'module', 'keepalive as keepAlive', 'type', 'permission_mark', 'hidden'
        ];

        // if user is super admin, will return all permissions
        if ($this->isSuperAdmin()) {
            $permissions = Permissions::query()->get($fields);
        } else {
            $this->roles()
                ->with([
                    'permissions' => function($query) use ($fields) {
                        $query->select($fields);
                    }
                ])->get()
                  ->each(function ($role) use (&$permissions) {
                    $permissions = $role['permissions']->concat($permissions);
                });

            $permissions = $permissions->unique();
        }

        if ($asTree) {
            return $permissions->toTree();
        }

        return $permissions;
    }

    /**
     * Do user have permission
     *
     * @time 2021年08月14日
     * @param $permissionId
     * @return mixed
     */
    public function hasPermission($permissionId)
    {
        return $this->permissions()->pluck('id')->contains($permissionId);
    }
}
