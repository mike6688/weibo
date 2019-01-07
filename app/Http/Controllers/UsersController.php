<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

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
    	// 如果我们需要获取 用户输入 的所有数据
    	// $data = $request->all();
    	// validate() 方法两个参数 1、用户输入的2、规则
    	$this->validate($request,[
    		'name' => 'required|max:50',
    		'email' => 'required|email|unique:users|max:255',
    		'password' => 'required|confirmed|min:6'
    	]);

    	// 用户模型 User::create() 创建成功返回 一个用户对象，并包含新用户注册的所有信息
    	$user = User::create([
    		'name' => $request->name,
    		'email' => $request->email,
    		'password' => bcrypt($request->password),
    	]);

    	//显示注册成功
    	//session()->flash('success','xxxxx');
    	//session临时保存 用户数据  session()会话实例化
    	//我们想存一条缓存数据，且它只在下一次的请求内有效可以用 flash方法 两个参数 1、键2、值  
    	//之后用  session()->get('success')取出
    	// session()->has('success') 判断是否有 jian为 success的session
        Auth::login($user);//login()自动登录函数 自动登录 
    	session()->flash('success','欢迎，您将在这里开启新的旅程！');

    	// 1、redirect('/')->back()   === back() 2、redirect()->with()
    	return redirect()->route('users.show',[$user]);
    	//以上代码 等同于(约定优于配置的体现，$user 是 User模型对象的实例，route()会自动获取Model的主键，也就是 userss的主键id)
    	// return redirect()->route('users.show',[$user->id]);
    	
    }
}
