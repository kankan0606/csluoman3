<?php
namespace app\index\controller;

use \think\Log;

class About extends BaseController{




 public function index(){
		   $this->assign(array(   
				'title'  => '关于我们|罗蔓婚庆|长沙婚庆|长沙婚庆公司|湖南婚庆'				
		));
    	
    	return $this->fetch();

    }
    
     public function planner(){
		 
		$this->assign(array(   
				'title'  => '罗蔓团|罗蔓婚庆|长沙婚庆|长沙婚庆公司|湖南婚庆'				
		));
		 
	    return $this->fetch();

    }
	
	 public function group(){
		 $this->assign(array(   
				'title'  => '罗蔓成长|罗蔓婚庆|长沙婚庆|长沙婚庆公司|湖南婚庆'			
		));
	
       return $this->fetch();

    }
	
	public function honor(){
		 $this->assign(array(   
				'title'  => '罗蔓荣誉|罗蔓婚庆|长沙婚庆|长沙婚庆公司|湖南婚庆'			
		));
	
        return $this->fetch();

    }
	
	
	public function zhaopin(){
		  $this->assign(array(   
				'title'  => '人才招聘|罗蔓婚庆|长沙婚庆|长沙婚庆公司|湖南婚庆'			
		));
	
        return $this->fetch();

    }
	
		public function link(){
		 
	 $this->assign(array(   
				'title'  => '联系我们|罗蔓婚庆|长沙婚庆|长沙婚庆公司|湖南婚庆'			
		));
        return $this->fetch();

    }
	
    
}