<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'finance_enewsuser';  //定义用户表名称
    protected $primaryKey = 'uid';    //定义用户表主键
    public $timestamps = false;         //是否有created_at和updated_at字段

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [   //可以被赋值的字段
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [ //在模型数组或 JSON 显示中隐藏某些属性
        'password', 'remember_token',
    ];


}
