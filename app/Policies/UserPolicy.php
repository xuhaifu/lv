<?php
/**
 * 授权策略 (Policy)
 * php artisan make:policy UserPolicy
 * 所有生成的授权策略文件都会被放置在 app/Policies 文件夹下。
 */
namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * todo::用户更新授权策略 (Policy)验证。
     *update 方法接收两个参数，第一个参数默认为当前登录用户实例，第二个参数则为要进行授权的用户实例。当两个 id 相同时，则代表两个用户是相同用户，用户通过授权，可以接着进行下一个操作。如果 id 不相同的话，将抛出 403 异常信息来拒绝访问。
     */
    public function update(User $currentUser, User $user)
    {
        return $currentUser->id === $user->id;
    }

    /**
     * todo::destroy 动作#    @can Blade 命令
        删除用户的动作，有两个逻辑需要提前考虑：
        只有当前登录用户为管理员才能执行删除操作；
        删除的用户对象不是自己（即使是管理员也不能自己删自己）。
     * Laravel 授权策略提供了 @can Blade 命令，允许我们在 Blade 模板中做授权判断。接下来让我们利用 @can 指令，在用户列表页加上只有管理员才能看到的删除用户按钮。
     */
    public function destroy(User $currentUser, User $user)
    {
        return $currentUser->is_admin && $currentUser->id !== $user->id;
    }
}
