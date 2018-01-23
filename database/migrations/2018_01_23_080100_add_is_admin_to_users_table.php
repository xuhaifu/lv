<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * php artisan make:migration add_is_admin_to_users_table --table=users
 * 新建的迁移文件中为用户添加一个 is_admin 的布尔值类型字段来判别用户是否拥有管理员身份，该字段默认为 false
 * 在迁移文件执行时对该字段进行创建，回滚时则需要对该字段进行移除。
 */
class AddIsAdminToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_admin')->default(false);
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
            $table->dropColumn('is_admin');
        });
    }
}
