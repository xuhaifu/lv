<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;

class SessionsController extends Controller
{
    public function __construct()
    {
        /**
         * 使用 Auth 中间件提供的 guest 选项，用于指定一些只允许未登录用户访问的动作，因此我们需要通过对 guest 属性进行设置，只让未登录用户访问登录页面和注册页面。
         */
        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }

    public function create()
    {
        return view('sessions.create');
    }

    public function store(Request $request)
    {
        $credentials = $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required'
        ]);

        /**
         * todo::是用AUTH的attempt方法做登录验证
         * attempt 方法会接收一个数组来作为第一个参数，该参数提供的值将用于寻找数据库中的用户数据。第二个参数为是否为用户开启『记住我』功能的布尔值
         * 因此在上面的例子中，attempt 方法执行的代码逻辑如下：
            使用 email 字段的值在数据库中查找；
            如果用户被找到：
            1). 先将传参的 password 值进行哈希加密，然后与数据库中 password 字段中已加密的密码进行匹配；
            2). 如果匹配后两个值完全一致，会创建一个『会话』给通过认证的用户。会话在创建的同时，也会种下一个名为 laravel_session 的 HTTP Cookie，以此 Cookie 来记录用户登录状态，最终返回 true；
            3). 如果匹配后两个值不一致，则返回 false；
            如果用户未找到，则返回 false。
         */
        /**
         * todo::redirect() 实例intended方法
         * redirect() 实例提供了一个 intended 方法，该方法可将页面重定向到上一次请求尝试访问的页面上，并接收一个默认跳转地址参数，当上一次请求记录为空时，跳转到默认地址上。
         */
        if (Auth::attempt($credentials, $request->has('remember'))) {
            session()->flash('success', '欢迎回来！');
            //todo::Laravel 提供的 Auth::user() 方法来获取 当前登录用户 的信息，并将数据传送给路由
            //todo::Laravel 提供了 Auth::check() 方法用于判断当前用户是否已登录，已登录返回 true，未登录返回 false（_header.blade.php）
            return redirect()->intended(route('users.show', [Auth::user()]));
        } else {
            session()->flash('danger', '很抱歉，您的邮箱和密码不匹配');
            return redirect()->back();
        }
    }

    public function destroy()
    {
        //todo::调用 Laravel 默认提供的 Auth::logout() 方法来实现用户的退出功能
        Auth::logout();
        session()->flash('success', '您已成功退出！');
        return redirect('login');
    }
}
