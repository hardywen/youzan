<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateYouzanUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('youzan_users', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('owner_type')->comment('从属类型,例如merchants');
            $table->unsignedInteger('owner_id')->comment('从属id,例如merchants表的id');

            $table->unsignedInteger('user_id')->comment('有赞用户的id');
            $table->string('nick_name')->comment('有赞用户的昵称');
            $table->string('avatar')->comment('有赞用户的头像');

            $table->string('access_token')->comment('有赞access_token');
            $table->unsignedInteger('expires_in')->comment('AccessToken 的有效时长，单位：秒');
            $table->timestamp('expires_at')->comment('AccessToken过期时间点');
            $table->string('token_type')->comment('令牌类型');
            $table->string('scope')->comment('AccessToken 最终的访问范围');
            $table->string('refresh_token')->comment('用于刷新 AccessToken 的 RefreshToken，不是所有的应用都有该参数（过期时间：28 天）');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('youzan_users');
    }
}
