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

namespace CatchAdmin\Permissions\Http\Controllers;

use CatchAdmin\Permissions\Events\LoginLog;
use CatchAdmin\Permissions\Exception\LoginFailedException;
use CatchAdmin\Permissions\Exception\UserForbiddenException;
use CatchAdmin\Permissions\Http\Requests\LoginRequest;
use CatchAdmin\Permissions\Models\Users;
use Catcher\Base\CatchResponse;
use Catcher\Exceptions\FailedException;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController
{
    /**
     * login
     *
     * @time 2021年08月09日
     * @param LoginRequest $request
     * @return array
     */
    public function login(LoginRequest $request): array
    {
        try {
            $token = Auth::attempt($request->only(['email', 'password']));
            if (! $token) {
                throw new LoginFailedException();
            }

            /* @var Users $user */
            $user = Auth::user();
            if ($user->status == Users::DISABLE) {
                throw new UserForbiddenException();
            }

            // update remember token
            $user->remember_token = $token;
            $user->save();

            event(new LoginLog('success'));
            return CatchResponse::success([
                'token' => $token
            ]);
        } catch (\Exception $e) {
            event(new LoginLog('failed'));
            throw new FailedException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * 登出
     *
     * @time 2021年08月17日
     * @return array
     */
    public function logout(): array
    {
        if (Auth::user()) {
            Auth::logout();
        }

        return CatchResponse::success([]);
    }

    /**
     * login user
     *
     * @time 2021年08月17日
     * @return array
     */
    public function user(): array
    {
        /* @var Users $user */
        $user = Auth::user();

        $user->roles = $user->roles()->pluck('identify');

        $user->permissions = $user->permissions();

        return CatchResponse::success($user);
    }
}
