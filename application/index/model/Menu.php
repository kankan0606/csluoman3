<?php
namespace app\index\model;

use think\Model;

class Menu extends Model
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
		$status	=	[0=>'不显示',1=>'显示'];
		return	$status[$value];
	}
		
	
	public	function	getPathAttr($value)
	{
		return	strpos($value,'-')?str_replace('-','/',$value):$value;;
	}
	
	//cate_path
	
	public	function	getCatePathAttr($value)
	{
		return	strpos($value,'-')?str_replace('-','/',$value):$value;;
	}
}