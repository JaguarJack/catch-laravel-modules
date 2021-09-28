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

use CatchAdmin\Permissions\Events\LoginLog as Event;
use CatchAdmin\Permissions\Models\LoginLog as LoginLogModel;

class LoginLog
{
    public function handle(Event $event)
    {
        $params = $event->params;

        $params['status'] = $params['status'] == 'success' ? 1 : 2;

        $userAgent = request()->header('user-agent');

        LoginLogModel::query()->insert([
            'login_name' => $params['email'],
            'login_ip'   => request()->ip(),
            'browser'    => $this->browser($userAgent),
            'os'         => $this->os($userAgent),
            'login_at'   => time(),
            'status'     => $params['status']
        ]);
    }


    /**
     *
     * @time 2019年12月12日
     * @param $agent
     * @return string
     */
    private function os($agent): string
    {
        if (stripos($agent, 'win') !== false && preg_match('/nt 6.1/i', $agent)) {
            return 'Windows 7';
        }
        if (stripos($agent, 'win') !== false && preg_match('/nt 6.2/i', $agent)) {
            return 'Windows 8';
        }
        if(stripos($agent, 'win') !== false && preg_match('/nt 10.0/i', $agent)) {
            return 'Windows 10';
        }
        if (stripos($agent, 'win') !== false && preg_match('/nt 5.1/i', $agent)) {
            return 'Windows XP';
        }
        if (stripos($agent, 'linux')) {
            return 'Linux';
        }
        if (stripos($agent, 'mac')) {
            return 'macos';
        }

        return 'Unknown';
    }

    /**
     *
     * @time 2019年12月12日
     * @param $agent
     * @return string
     */
    private function browser($agent): string
    {
        if (stripos($agent, 'MSIE') !== false) {
            return 'MSIE';
        }
        if (stripos($agent, 'Firefox') !== false) {
            return 'Firefox';
        }
        if (stripos($agent, 'Chrome') !== false) {
            return 'Chrome';
        }
        if (stripos($agent, 'Safari') !== false) {
            return 'Safari';
        }
        if (stripos($agent, 'Opera') !== false) {
            return 'Opera';
        }

        return 'Unknown';
    }
}
