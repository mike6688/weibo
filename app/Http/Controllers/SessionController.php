<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class SessionController extends Controller
{
    //登录页面
    
    public function create(){
    	return view('sessions.create');
    }

    // 验证登录
    
    public function store(Request $request){
    	$credentials = $this->validate($request,[
    		'email' => 'required|email|max:255',
    		'password' => 'required'
    	]);
    	//attempt() 可接受两个参数 1、用户数组 2、是否开启记住我 布尔值 $request->has() 判断是否有值
    	if(Auth::attempt($credentials,$request->has('remember'))){
    		session()->flash('success','欢迎回来！');
    		return redirect()->route('users.show',[Auth::user()]);
    		// Auth::user() 获取当前 登录用户信息，并将数据传递给路由
    	}else{
    		session()->flash('danger','抱歉，您的邮箱和密码不匹配');
    		return redirect()->back()->withInput();
    	// withInput() 当用户输错后 与前端页面 old()相结合 返回之前的数据
    	}
    	
    }

    // 注销方法
    public function destroy(){
    	Auth::logout();
    	session()->flash('success','您已成功退出！');
    	return redirect('login');
    }
}
