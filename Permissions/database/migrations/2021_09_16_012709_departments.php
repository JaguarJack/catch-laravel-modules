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

class Departments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('departments', function (Blueprint $table){
            $table->id();

            $table->string('department_name', 15)->default('')->comment('部门名称');

            $table->parentId();

            $table->string('principal', 20)->default('')->comment('负责人');

            $table->string('mobile', 20)->default('')->comment('联系电话');

            $table->string('email', 100)->default('')->comment('联系邮箱');

            $table->creatorId();

            $table->sort();

            $table->status();

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
        Schema::dropIfExists('departments');
    }
}
