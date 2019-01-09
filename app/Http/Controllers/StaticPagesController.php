<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status;
use Auth;

class StaticPagesController extends Controller
{
    //主页
    public function home(){
    	// return 'home';
    	// return只会返回字符串  我们要用到  view()
    	// view()接受两个参数 1、视图的路径名称 2、数据（可选参数）
        $feed_items = [];
        if(Auth::check()){
            $feed_items = Auth::user()->feed()->paginate(30);
        }
    	return view('static_pages/home',compact('feed_items'));
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
