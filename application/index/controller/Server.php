<?php

namespace app\index\controller;

class Server extends BaseController{
	
	public function index(){
		  $this->assign(array(   
				'title'  => '罗蔓服务|罗蔓婚庆|长沙婚庆|长沙婚庆公司|长沙最好的婚庆公司|长沙庆典策划公司|湖南婚庆 - 罗蔓婚庆'				
		));
		 
		return $this->fetch();
	
	}
}

?>