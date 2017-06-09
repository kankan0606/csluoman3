<?php
namespace app\index\controller;


class Price extends BaseController {
	
    public function index(){
		   
    	
    	$pricetype = $this->request->has('type')? $this->request->param('type'):1;
    	
    	$ar=\think\Config::get('PRICETYPE.'.$pricetype);
    	
    	if(is_array($ar)){
    		$location_tit=$ar[0];
    		$location_en =$ar[1];
    	}
    	
    	
    	$map['price_type'] = array('eq',$pricetype);    	
    	$map['price_status'] = array('eq',1);

    	$query =  \think\Db::name('price')
			    	->where($map)
			    	->order('price_order desc');
    		
    	$price_paginate=$query->paginate(4);
    	
    	$this->assign([
    			'title'  => '套餐报价|'.\think\Config::get('TITLE'),
    			'location'  =>  $location_tit,             // 导航
    			'location_tit'=>$location_tit,
    			"location_en"=>$location_en,
    			'plist'=>$price_paginate->getCollection(),
    			'page'=>$price_paginate->render(),
    			      ]
    	    );
    	return $this->fetch();

    }
	
	public function test(){
		
		$this->display();
		}
    
     public function showcon(){
     	
     	$pricetype = $this->request->has('type')? $this->request->param('type'):1;
       // $pricetype = isset($_GET['type'])?$_GET['type']:1;
        $menuid = $this->request->param('menuid');
    	
    	$ar=\think\Config::get('PRICETYPE.'.$pricetype);
    	
    	if(is_array($ar)){
    		$location_tit=$ar[0];
    		$location_en =$ar[1];
    	}
    	
     	$p_id = $this->request->has('p_id')? $this->request->param('p_id'):0;
     		
     	if($p_id==0){
     		$this->error('错误的参数','/Price/index/menuid/'.$menuid.'/');
     		
     	}
     		
     	$map['price_id'] = array('eq',$p_id);
     	
     	$price=\think\Db::name('price')->where($map)->find();
     	// 浏览次数加1
     	\think\Db::name('price')->where($map)->setInc('price_num');
     	
     	//获取内容
     	$map2['caption_id']=array('eq',$p_id);
     	$c_list=\think\Db::name('contents2')->where($map2)->select();
     	    	
     		
     	$this->assign(array(
     			'title'  => '套系报价|'.\think\Config::get('TITLE'),     		
     			'location_tit'=>$location_tit,
     			"location_en"=>$location_en,
     			'c_list'=>$c_list,
     			'price'=>$price,
     			
     	)
     	);
     	
     	
     	return $this->fetch();
     }
		
    
}
?>