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

namespace CatchAdmin\Permissions\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * rules
     *
     * @time 2021年08月12日
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email',

            'password' => 'required'
        ];
    }


    /**
     * messages
     *
     * @time 2021年08月12日
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'email' => '邮箱',

            'password' => '密码'
        ];
    }
}
