<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status;
use Auth;

class StatusesController extends Controller
{
    public function __construct(){
    	$this->middleware('auth');
    }

    public function store(Request $request){
    	$this->validate($request,[
    		'content'=>'required|max:140'
    	]);

    	Auth::user()->statuses()->create([
    		'content'=>$request['content'],
    	]);
    	session()->flash('success','发布成功！');
    	return redirect()->back();
    }

    public function destroy(Status $status){ // 括号内是  隐形路由模型绑定  laravel会自动查找并注入 对应 id的实例对象  $status
        $this->authorize('destroy',$status); //策略授权检测
        $status->delete();
        session()->flash('success','微博已经成功删除！');
        return redirect()->back();
    }
}
