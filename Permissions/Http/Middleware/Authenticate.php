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

namespace CatchAdmin\Permissions\Http\Middleware;

use Catcher\Exceptions\FailedException;
use Catcher\Support\Code;
use Closure;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth as Auth;

class Authenticate
{
    /**
     * handle
     *
     * @time 2021年08月14日
     * @param $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
           if (! Auth::parseToken()->authenticate()) {
             throw new FailedException('User Not Found');
           }
        } catch (\Exception $e) {
            $this->renderException($e);
        }

        return $next($request);
    }


    /**
     * render exception
     *
     * @time 2021年08月14日
     * @param $e
     * @return void
     */
    protected function renderException($e)
    {
        if ($e instanceof TokenBlacklistedException) {
            throw new FailedException('Token 已进入黑名单', Code::LOGIN_BLACKLIST);
        }

        if ($e instanceof TokenInvalidException) {
            throw new FailedException('Token 不合法', Code::LOGIN_FAILED);
        }

        if ($e instanceof TokenExpiredException) {
            throw new FailedException('Token 过期', Code::LOGIN_EXPIRED);
        }

        throw new FailedException('认证不合法', Code::LOST_LOGIN);
    }
}
