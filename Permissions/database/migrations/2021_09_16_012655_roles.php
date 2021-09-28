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

class Roles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('roles', function (Blueprint $table){
           $table->id();

           $table->parentId();

           $table->string('role_name', 15)->comment('角色名称')->default('')->nullable(false);

           $table->string('identify',20)->default('')->comment('角色的标识，用英文表示，用于后台路由权限');

           $table->string('description')->default('')->comment('角色备注');

           $table->tinyInteger('data_range')->default(1)->comment('1 全部数据 2 自定义数据 3 仅本人数据 4 部门数据 5 部门及以下数据');

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
        Schema::dropIfExists('roles');
    }
}
