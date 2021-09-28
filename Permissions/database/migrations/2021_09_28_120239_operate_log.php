<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OperateLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('operate_log', function (Blueprint $table){
            $table->bigIncrements('id');

            $table->string('module', 20)->comment('模块名称')->default('');

            $table->string('operate', 50)->comment('操作名称')->default('');

            $table->string('route', 100)->comment('路由')->default('');

            $table->string('params', 2000)->default('')->comment('参数');

            $table->string('ip', 20)->comment('ip');

            $table->creatorId();

            $table->string('method')->comment('HTTP Method')->default('');

            $table->createdAt();
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
        Schema::dropIfExists('operate_log');
    }
}
