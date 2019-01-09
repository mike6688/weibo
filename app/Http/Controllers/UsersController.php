<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Mail;

class UsersController extends Controller
{
    public function __construct(){
        $this->middleware('auth',[ //middleware中间件函数 参数1、键名2、哪些方法用/不用中间件
            'except' => ['create','store','index','confirmEmail']  // except指这些键 不需要 经过 2、only 与 except相反 仅仅需要  那些键 用中间件
        ]);
        $this->middleware('guest',[
            'only' =>['create']
            ]);
    }

    //列表
    public function index(){
        // paginate(10)
        $users = User::paginate(10);
        return view('users.index',compact('users'));
    }

    //管理员 删除用户
    public function destroy(User $user){
        $this->authorize('destroy',$user);
        $user->delete();
        session()->flash('success','成功删除用户！');
        return back(); //重定向 上一次 进行删除操作的页面
    }

    //注册页面
    public function create(){
    	return view('users.create');
    }

    //显示页面
    public function show(User $user){ //$user 必须和 路由中{$user}意思必须有参数
    	// 将 用户对象 $user 通过 compact 方法 转化为一个关联数组
    	// compact是将变量转为 关联数组
        $statuses = $user->statuses()
                            ->orderBy('created_at','desc')
                            ->paginate(10); 
    	return view('users.show',compact('user','statuses'));
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
        //Auth::login($user);//login()自动登录函数 自动登录 
    	//session()->flash('success','欢迎，您将在这里开启新的旅程！');

    	// 1、redirect('/')->back()   === back() 2、redirect()->with()
    	//return redirect()->route('users.show',[$user]);
    	//以上代码 等同于(约定优于配置的体现，$user 是 User模型对象的实例，route()会自动获取Model的主键，也就是 userss的主键id)
    	// return redirect()->route('users.show',[$user->id]);
    	$this->sendEmailConfirmationTo($user);
        session()->flash('success','验证邮件已发送到你的注册邮箱上，请注意查收。');
        return redirect('/');
    }

    // 发送 邮件
    protected function sendEmailConfirmationTo($user){
        $view = 'emails.confirm';
        $data = compact('user');
        $from = '1240817502@qq.com';
        $name = 'yang';
        $to = $user->email;
        $subject = "感谢注册新浪微博，请确定您的邮箱！";

        Mail::send($view,$data,function($message) use ($from,$name,$to,$subject){
            $message->to($to)->subject($subject);
        });
    }

    //修改资料页面
    public function edit(User $user){
        $this->authorize('update',$user);
        return view('users.edit',compact('user'));
    }

    //update页面  User $user 利用 laravel 隐形 路由模型绑定  读取对应的id用户实例 $user
    public function update(User $user,Request $request){
        $this->authorize('update',$user);
        $this->validate($request,[
            'name' => 'required|max:50',
            'password' => 'nullable|confirmed|min:6'
        ]);

        $data = [];
        $data['name'] = $request->name;
        if($request->password){
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        session()->flash('success','个人资料更新成功！');

        return redirect()->route('users.show',$user->id);
    }

    //确认邮件
    public function confirmEmail($token){
        $user = User::where('activation_token',$token)->firstOrFail();

        $user->activated = true;
        $user->activation_token = null;
        $user->save();

        Auth::login($user);

        session()->flash('success','恭喜你，激活成功！');
        return redirect()->route('users.show',[$user]);
    }
}
