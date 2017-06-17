<?php
namespace app\index\controller;


class Info extends BaseController {
	
public function index(){

		    	 
		    $strlen=40;  //限制数据显示长度 
		      
			$dongtai_list= \think\Db::name('caption')->where('c_status=1 and c_type=1' ) ->order ('c_date desc')->limit(5)->select();
			$wenti_list= \think\Db::name('caption')->where('c_status=1 and c_type=2') ->order ('c_date desc')->limit(5)->select();
			$choubei_list= \think\Db::name('caption')->where('c_status=1 and c_type=3') ->order ('c_date desc')->limit(5)->select();
		    
			$dongtai_list=addKeyForCaption($dongtai_list,$strlen,'c_name');
			$wenti_list=addKeyForCaption($wenti_list,$strlen,'c_name');
			$choubei_list=addKeyForCaption($choubei_list,$strlen,'c_name');
			
		     $this->assign('dongtai_list',$dongtai_list);// 赋值数据集
			 $this->assign('wenti_list',$wenti_list);// 赋值数据集
			 $this->assign('choubei_list',$choubei_list);// 赋值数据集
             $this->assign('title','最新资讯|'.\think\Config::get('TITLE'));			 
             return $this->fetch();

		 
    }
	
	
    
    public function showcaptions(){
		
		  $c_type = $this->request->has('type')? $this->request->param('type'):1;
		  $menuid = $this->request->param('menuid');
					 
		  switch ($c_type){
			 case 1:
			   $location     = "<a href=\"/\" class=\"black12\">首页</a> &gt;<a href=\"/new/index/menuid/".$menuid."/\" class=\"black12\">最新资讯</a> &gt; 公司动态";
			   $location_tit = "公司动态";
			   $location_en  = "NEW";
			   $this->assign('title','公司动态|'.\think\Config::get('TITLE'));
			   break;
			 case 2:
			   $location     = "<a href=\"/\" class=\"black12\">首页</a> &gt;<a href=\"/new/index/menuid/".$menuid."/\" class=\"black12\">最新资讯</a> &gt; 婚礼文化";
			   $location_tit = "婚礼文化";
			   $location_en  = "QUESTION";
			   $this->assign('title','婚礼文化|'.\think\Config::get('TITLE'));
			   break;
			 case 3:
			   $location     = "<a href=\"/\" class=\"black12\">首页</a> &gt;<a href=\"/new/index/menuid/".$menuid."/\" class=\"black12\">最新资讯</a> &gt; 婚礼筹备";
			   $location_tit = "婚礼筹备";
			   $location_en  = "PREPARE";
			   $this->assign('title','婚礼筹备|'.\think\Config::get('TITLE'));
			   break;
			 case 4:
			   $location     = "<a href=\"/\" class=\"black12\">首页</a> &gt;<a href=\"/new/index/menuid/".$menuid."/\" class=\"black12\">套系报价</a> &gt; 套系内容";
			   $location_tit = "套系内容";
			   $location_en  = "PRICE";
			   $this->assign('title','套系报价|'.\think\Config::get('TITLE'));
			   break;
			 default:
			   $this->error('错误的参数','/new/index/menuid/'.$menuid.'/');
		  }
			 
	      $map['c_type']   = array('eq',$c_type);			 
		  $map['c_status'] = array('eq',1);
		  
		  $query  = \think\Db::name('caption')
					->field('c_id,c_type,c_name,date_format(c_date,\'%Y-%m-%d\') as c_date')
					->where($map)
					->order('c_date desc');
		  
		  $caption_paginate = $query->paginate(7);
		 
		 
		  $plist = $caption_paginate->items();
		  
		
		  
		 // \think\Log::write('$caption_paginate->items():'.$caption_paginate->items());
		  $plist = addKeyForCaption($plist,100,'c_name');
         
          $this->assign(
          		    array(
                             'location'  =>  $location,             // 导航
							 'location_tit'=>$location_tit,
							 "location_en"=>$location_en,
							 'plist'=>$plist,
							 'page'=>$caption_paginate->render(),
							 'c_type'=>$c_type
                         )
					  );
         
		     return $this->fetch();
		
		}
		 
		
        public function showcontent(){
			
            $c_type = $this->request->has('type')? $this->request->param('type'):1;
            $menuid = $this->request->param('menuid');
            
		
			switch ($c_type)
			{
			 case 1:
			   $location="<a href=\"/\" class=\"black12\">首页</a> &gt;<a href=\"/new/index/menuid/".$menuid."/\" class=\"black12\">最新资讯</a> &gt; 公司动态";
			   $location_tit="公司动态";
			   $location_en="NEW";
			   $title='公司动态|长沙婚庆|长沙婚庆公司|长沙庆典策划公司|湖南婚庆 - 罗蔓婚庆';
			   break;
			 case 2:
			   $location="<a href=\"/\" class=\"black12\">首页</a> &gt;<a href=\"/new/index/menuid/".$menuid."/\" class=\"black12\">最新资讯</a> &gt; 婚礼文化";
			 $location_tit="婚礼文化";
			 $location_en="QUESTION";
			 $title='婚礼文化|长沙婚庆|长沙婚庆公司|长沙庆典策划公司|湖南婚庆 - 罗蔓婚庆';
			  break;
			 case 3:
			   $location="<a href=\"/\" class=\"black12\">首页</a> &gt;<a href=\"/new/index/menuid/".$menuid."/\" class=\"black12\">最新资讯</a> &gt; 婚礼筹备";
			 $location_tit="婚礼筹备";
			 $location_en="PREPARE";
			 $title='婚礼筹备|长沙婚庆|长沙婚庆公司|长沙庆典策划公司|湖南婚庆 - 罗蔓婚庆';
			  break;
			default:
			  $this->error('错误的类型参数','new/index/menuid/'.$menuid.'/');
			}
			
			$c_id = $this->request->has('c_id')? $this->request->param('c_id'):0;
			
			
			if($c_id==0){
			    $this->error('错误的参数','/new/index/menuid/'.$menuid.'/'); 	
			}
			
			
			$map['c_id'] = array('eq',$c_id);
			$map['c_status'] = array('eq',1);
			
			$data  = db('caption',[],false)
			   ->field('c_id,c_name,date_format(c_date,\'%Y-%m-%d\') as c_date,c_num')->where($map)->find();//文章标题与浏览次数，更新日期
			
			$data=addKeyForCaption($data,null,'c_name');
			
		
			// 浏览次数加1
			db('caption',[],false)->where($map)->setInc('c_num');
			
			//获取内容
			$map2['caption_id']=array('eq',$c_id);
			$c_list=db('contents',[],false)->where($map2)->select();
			
			$c_list=addKeyForContent($c_list,'content');
			
			//上一篇
			$sqlstr   = 'select * from tb_csluoman_caption a  ';
            $sqlstr  .= 'where UNIX_TIMESTAMP(a.c_date) < ( ';
            $sqlstr  .= 'select UNIX_TIMESTAMP(b.c_date) from tb_csluoman_caption b where b.c_id='.$c_id.') ';
            $sqlstr  .= 'order by c_date asc   limit 1';
			
            $pre_caption = \think\Db::query($sqlstr);
			                       
			$pre_caption=addKeyForCaption($pre_caption,null,'c_name');
			
			$item = $pre_caption[0];
	
			$pre_str='上一篇：<a href="/new/content/type/'.$item['c_type'].'/menuid/'.$menuid.'/c_id/'.$item['c_id'].'/" title="'.$item['c_name'].'">'.$item['c_name'].'</a>';
			
			if(empty($item['c_name'])){
				 $pre_str='上一篇：没有了'; 
		    }		   
		   
			//下一篇
			$sqlstr   = 'select * from tb_csluoman_caption a  ';
            $sqlstr  .= 'where UNIX_TIMESTAMP(a.c_date) > ( ';
            $sqlstr  .= 'select UNIX_TIMESTAMP(b.c_date) from tb_csluoman_caption b where b.c_id='.$c_id.') ';
            $sqlstr  .= 'order by c_date desc   limit 1';
		    
            $next_caption = \think\Db::query($sqlstr);
		     
			$next_caption=addKeyForCaption($next_caption,null,'c_name');
			
			$item = $next_caption[0];
			
			$nex_str='下一篇：<a href="/new/content/type/'.$item['c_type'].'/menuid/'.$menuid.'/c_id/'.$item['c_id'].'/" title="'.$item['c_name'].'">'.$item['c_name'].'</a>';
			
			  if(empty($item['c_name'])){
				 $nex_str='下一篇：没有了'; 
		      }		
		    
			$this->assign(array(
                            'title'  => $title,
                             'location'  =>  $location,             // 导航
							 'location_tit'=>$location_tit,
							 "location_en"=>$location_en,
							 'c_type'=>$c_type,
							 'c_name'=>$data['c_name'],
							 'c_num'=>$data['c_num'],
							 'c_date'=>$data['c_date'],
							 'c_list'=>$c_list,
							 'pre_str'=>$pre_str,
							 'nex_str'=>$nex_str
                         )
					  );
		  
		  
		 $this->fetch(); // 输出模板
			
			
		}
}