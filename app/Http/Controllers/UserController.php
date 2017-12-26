<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Symfony\Component\VarDumper\Cloner\Data;

use Carbon\Carbon;

class UserController extends Controller
{

    /**
     * @desc index
     * @author xhf
     * @date 2017/12/26 15:51
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $users = DB::table('users')->get();
        return view('user.index', ['users' => $users]);
    }


    /**
     * @desc 显示用户详情
     * @author xhf
     * @date 2017/12/26 17:10
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        if(!Hash::check($user['name'],$user['password'])){
            dd('密码不正确');
        }
        return view('user.profile', ['user' => $user]);
    }

    /**
     * @desc 添加数据
     * @author xhf
     * @date 2017/12/26 16:01
     */
    public function setUser()
    {
        $az_arr = range('a','z');
        $data = [];
        for($j=0;$j<1;$j++){
            $str = '';
            for($i=0;$i<4;$i++){
                $rand = rand(1,count($az_arr)-1);
                $str .= $az_arr[$rand];
            }
            $data[$j] = [
                'name' => $str,
                'email' => $str.'@example.com',
                'password' => Hash::make($str),
                'created_at' => Carbon::now()->toDateTimeString()
            ];

        }
        DB::table('users')->insert($data);
    }
}
