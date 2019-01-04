<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaticPagesController extends Controller
{
    //主页
    public function home(){
    	// return 'home';
    	// return只会返回字符串  我们要用到  view()
    	// view()接受两个参数 1、视图的路径名称 2、数据（可选参数）
    	$data = array();
    	return view('static_pages/home',$data);
    }
    // 帮助页
    public function help(){
    	// 注意 blade 是一套模板引擎
    	return view('static_pages/help');
    }

    public function about(){
    	return view('static_pages/about');
    }
}
