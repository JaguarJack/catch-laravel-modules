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

class Permissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('permissions', function (Blueprint $table){
           $table->id();

           $table->string('permission_name', 15)->default('')->comment('菜单名称');

            $table->parentId();

            $table->string('level', 50)->comment('层级')->default('');

            $table->string('route', 50)->comment('路由')->default('');

            $table->string('icon', 50)->default('')->comment('icon');

            $table->string('module', 20)->default('')->comment('模块');

            $table->string('permission_mark')->default('')->comment('权限标识');

            $table->string('component')->default('')->comment('组件名称');

            $table->string('redirect')->default('')->comment('跳转地址');

            $table->tinyInteger('keepalive')->default(1)->comment('1 缓存 2 不存在 ');

            $table->tinyInteger('type')->default(1)->comment('1 菜单 2 按钮');

            $table->tinyInteger('hidden')->comment('1 显示 2 隐藏')->default(1);

            $table->sort();

           $table->creatorId();

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
        Schema::dropIfExists('permissions');
    }
}
