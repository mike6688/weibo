<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Auth;

class User extends Authenticatable
{
    use Notifiable;


    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function boot(){
        parent::boot();

        static::creating(function($user){
            $user->activation_token = str_random(30);
        });
    }
    // 获取头像 的方法
    public function gravatar($size = '100'){
        // $hash = md5(strtolower(trim('$this->attributes['email']')));
        $hash = md5(strtolower(trim('jianyang8665@gmail.com')));
        return "http://www.gravatar.com/avatar/$hash?s=$size";
        //attributes 作用是 设置请求参数错误时  各个字段的名称
        ////$this->attributes['email'] 获取到用户的邮箱
        
    }

    public function statuses(){
        // 模型关联一对多 
        return $this->hasMany(Status::class);
    }

    //首页 微博列表
    public function feed(){
        $user_ids = $this->followings->pluck('id')->toArray();
        array_push($user_ids,$this->id);
        return Status::whereIn('user_id',$user_ids)
                                ->with('user')
                                ->orderBy('created_at','desc');
    }

    //可以获取粉丝列表  模型关联 多对多
    public function followers(){
        return $this->belongsToMany(User::Class,'followers','user_id','follower_id');
    }
    // 可以获取关注人列表
    public function followings(){
        return $this->belongsToMany(User::Class,'followers','follower_id','user_id');
    }

    public function follow($user_ids)
    {
        if ( ! is_array($user_ids)) {
            $user_ids = compact('user_ids');
        }
        $this->followings()->sync($user_ids, false);
    }

    public function unfollow($user_ids)
    {
        if ( ! is_array($user_ids)) {
            $user_ids = compact('user_ids');
        }
        $this->followings()->detach($user_ids);
    }

    //判断是否关注
    public function isFollowing($user_id){
        return $this->followings->contains($user_id);
    }
}
