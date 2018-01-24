<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * php artisan make:migration add_activation_to_users_table --table=users
 * 在用户的账号激活功能中，我们需要为激活令牌 (activation_token) 和激活状态 (activated) 字段新增一个迁移，来将这两个字段添加到用户表中。由于我们进行的是字段添加操作，因此在命名迁移文件时需要加上前缀，遵照如 add_column_to_table 这样的命名规范，并在生成迁移文件的命令中启用 --table 项目
 */
class AddActivationToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('activation_token')->nullable();
            $table->boolean('activated')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('activation_token');
            $table->dropColumn('activated');
        });
    }
}
