<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LoginLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('login_log', function (Blueprint $table){
            $table->bigIncrements('id');

            $table->string('login_name', 50)->comment('用户名')->default('');

            $table->string('login_ip', 20)->comment('登陆地点 IP')->default('');

            $table->string('browser', 50)->comment('浏览器')->default('');

            $table->string('os', 20)->comment('操作系统')->default('未知');

            $table->integer('login_at')->comment('登陆时间');

            $table->tinyInteger('status')->comment('1 成功 2 失败')->default(1);
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
        Schema::dropIfExists('login_log');
    }
}
