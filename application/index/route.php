<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\Route;

//Route::rule('test/','index/index/test');
//Route::controller('user','index/User');

//Route::rule('user/','index/User/getInfo');


//Route::rule(['user','user/:info/:name'],'index/User/getInfo','GET');
//Route::controller('test','index/index');


return [
    
    'case/'       => 'index/Anli/index',
    'about/planner'       => 'index/about/planner',
    'about/index'       => 'index/about/index',
    'about/link'       => 'index/about/link',
    'about/honor'       => 'index/about/honor',
    'about/zhaopin'       => 'index/about/zhaopin',
    'about/group'       => 'index/about/group',
    'server/index'       => 'index/server/index',
    'price/index'       => 'index/price/index',
    'price/showcon'       => 'index/price/showcon',
    'new/index'       => 'index/info/index',
    'new/captions'       => 'index/info/showcaptions',
    'new/content'       => 'index/info/showcontent',
];
