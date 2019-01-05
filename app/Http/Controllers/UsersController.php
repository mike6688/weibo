<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    //注册页面
    public function create(){
    	return view('users.create');
    }

    //显示页面
    public function show(User $user){ //$user 必须和 路由中{$user}意思必须有参数
    	// 将 用户对象 $user 通过 compact 方法 转化为一个关联数组
    	// compact是将变量转为 关联数组
    	return view('users.show',compact('user'));
    }

    //  注册表单
    public function store(Request $request){
    	// validate() 方法两个参数 1、用户输入的2、规则
    	$this->validate($request,[
    		'name' => 'required|max:50',
    		'email' => 'required|email|unique:users|max:255',
    		'password' => 'required|confirmed|min:6'
    	]);
    	
    }
}
