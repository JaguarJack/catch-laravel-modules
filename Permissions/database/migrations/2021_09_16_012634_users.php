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

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Users extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('users', function (Blueprint $table){
            $table->id();

            $table->string('username', 15)->default('')->nullable(false)->comment('用户名');

            $table->string('password')->default('')->nullable(false)->comment('密码');

            $table->string('email', 30)->nullable(false)->default('')->comment('密码');

            $table->string('avatar')->default('')->comment('头像');

            $table->string('remember_token', 512)->default('')->comment('用户 token');

            $table->integer('creator_id')->default(0)->comment('创建人ID');

            $table->integer('department_id')->default(0)->comment('部门ID');

            $table->tinyInteger('status')->default(1)->comment('1 正常 2 禁用');

            $table->string('last_login_ip', 50)->default('')->comment('最后登陆IP');

            $table->integer('last_login_time')->default(0)->comment('最后登陆时间');

            $table->unixTimestamp();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('users');
    }
}
