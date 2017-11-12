<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     *显示用户详情
     */
    public function show($id){
        return view('user.profile', ['user' => User::findOrFail($id)]);
    }
}
