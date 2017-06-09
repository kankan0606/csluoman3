<?php
namespace app\index\model;

use think\Model;

class User extends Model
{
	
	//自定义初始化
	protected	function	initialize()
	{
		//需要调用`Model`的`initialize`方法
		parent::initialize();
		//TODO:自定义的初始化
	}
	public	function	getStatusAttr($value)
	{
		//\think\Log::write('----------this1111-------','info');
		$status	=	[-1=>'删除',0=>'禁用',1=>'正常',2=>'待审核'];
		return	$status[$value];
	}
	public	function	getLastlogintimeAttr($value)
	{
		///\think\Log::write('----------this22222-------','info');
		$last_login_time	=	date('Y-m-d',$value);
		return	$last_login_time;
	}
	
}