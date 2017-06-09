<?php 
namespace app\index\controller;

use \think\Log;

class Anli extends BaseController
{
	
	/**
	 * 初始化重写
	 * @see BaseAction::_initialize()
	 */
	function _initialize()
	{
		//导航栏
		 $menu = new \app\index\model\Menu();
		    
		    
			$menulist=$menu->where('status','1')
							->where('level',1)
							->order('order_key')
							->select();
		
		$this->assign(array(
				'title'  => '罗蔓案例|长沙婚庆|长沙婚庆公司|长沙最好的婚庆公司|长沙庆典策划公司|湖南婚庆 - 罗蔓婚庆唯一官方网站',
				'keywords'=>'长沙婚庆,湖南婚庆,长沙婚庆公司,长沙婚礼策划,长沙最好的婚庆公司,长沙婚礼策划公司,长沙庆典策划公司,罗蔓婚庆公司',
				'description'=>'罗蔓婚庆打造个性首选的婚庆公司策划团队,长沙最好的婚庆策划品牌、资深策划、满意百分百婚礼策划、主持、布置、婚车、化妆、摄影、酒店预订一条龙服务。电话：0731-84221468。',
				'navigation'  => $menulist,    // 导航
	
		));
	}
	
	public function index(){
		
		$id = $this->request->has('menuid')? $this->request->param('menuid'):0;
		
		$show = 'case';	

		$url=\think\Url::build('index/anli/index','','','');
		
		$leftmenulist =  $this->get_leftmenu1($show,$url);
		
		$pic_series = $this->request->has('pic_series')? $this->request->param('pic_series'):'';
		 
		$pic_type = $this->request->has('series_type')? $this->request->param('series_type'):'';
		
	    $case_title='';
		$case_navigation='';
		
		
		
		$this->assign('list',$leftmenulist);
		$this->assign('menuid',$id);
		$this->assign('url',$url);
		
		if(!empty($pic_type)){//页面显示系列列表
			
			$map['series_type'] = array('eq',$pic_type);
			
			$map['show_type'] =array('eq',$show);
			
			$map['series_status']=array('eq',1);
			
			$query =  \think\Db::name('picseries')
					->alias('pic')
					->join('pictype pictype','pic.series_type = pictype.pictype_id')
					->where($map)
					->order('series_order desc');
			
			
			$case_paginate=$query->paginate(\think\Config::get('paginate.list_rows'),false,['type'=>'\zkk\paginate\AjaxPage']);
			
			
			// 进行分页数据查询
			$json['list'] = $case_paginate->getCollection();
			
			$json['page'] = $case_paginate->render();
			//标题与导航字符串
			foreach ($leftmenulist as $k=>$v){
				if($v['cate_Id']==$pic_type){
					$case_title=$v['cate_Name'];
					$case_navigation='<a href="/" class="black12">首页</a> &gt; <a href="/index.php/case/series_type/1/show/'.$show.'/" class="black12">'.'罗蔓案例'.'</a>&gt;'.$case_title;
					break;
				}
			}
			
			
			$json['case_title'] = 	$case_title;
			$json['case_navigation'] = 	$case_navigation;
			$json['series_type']=$pic_type;
			$json['banner']='<span id="showcn" class="font5">'.'罗蔓案例'.' </span><span id="showen" class="font6">'.strtoupper($show).' </span>';
			$json['show']=$show;
			$json['upload']=\think\Config::get('view_replace_str.__UPLOAD__');
			
			$json = json_encode($json);
		
			if($this->request->isAjax())
				
			{
				return $json;
			}else{
				
				$this->assign('json',$json);
				return $this->fetch();				
			}
		
		   
		
		}else if(!empty($pic_series)){  //页面显示该系列下的所有图片列表
		
		
			//浏览次数增加1次	
			 \think\Db::name('picseries')
			->where('series_id',$pic_series)
			->setInc('series_num');
		
			//$picM = M('piclib'); // 实例化Data数据对象	
			
			$map['pic_series'] = array('eq',$pic_series);
			$map['pic_show'] = array('eq',1);
		
			
			$case_paginate = \think\Db::name('piclib')
						->where($map)
						->order('pic_id desc')
						->paginate(\think\Config::get('paginate.list_rows'),false,['type'=>'\zkk\paginate\AjaxPage']);
				
		   
			// 进行分页数据查询
			$json['list'] =  $case_paginate->getCollection();
		
			$json['page'] = $case_paginate->render();
		
		
			foreach ($leftmenulist as $k=>$v){
				if($v['cate_Id']==$pic_series.$v['cate_ParentId']){
					$case_title=$v['cate_Name'];
					$pid= $v['cate_ParentId'];
					foreach($leftmenulist as $k1=>$v1){
						if($v1['cate_Id']==$pid){
							$case_navigation='<a href="/" class="black12">首页</a> &gt; <a href="/index.php/case/series_type/1/show/'.$show.'/" class="black12">'.'罗蔓案例'.'</a>&gt;<a href="/index.php/case/series_type/'.$pid.'/show/'.$show.'" class="black12">'.$v1['cate_Name'].'</a>&gt;'.$case_title;
							break;
						}
					}
					break;
				}
			}
		
			$json['case_title'] = 	$case_title;
			$json['case_navigation'] = 	$case_navigation;
			//$json['menuid']=$id;
			$json['pic_series']=$pic_series;
		
			$json['banner']='<span id="showcn" class="font5">'.'罗蔓案例'.' </span><span id="showen" class="font6">'.strtoupper($show).' </span>';
			$json['show']=$show;
			$json['upload']=\think\Config::get('view_replace_str.__UPLOAD__');
		
			$json = json_encode($json);
		
			if(!$this->request->isAjax())
			{
				$this->assign('json',$json);
				
				return $this->fetch();
			}
			else
			{
				return $json;
			}
		
		}else{
		
			return '参数不正确';
		}
		
	}
	
	public function get_leftmenu1($show,$url){
		// concat('show_page(1,0,"pic_series-',series_id,'")')
		$sqlstr   =   '  select pictype_id as cate_Id,0 as cate_ParentId,  pictype_name as cate_Name,';
		$sqlstr  .=   '  concat(\'javascript:show_page(1,\\\'series_type/\',pictype_id,\'\\\',\\\''.$url.'\\\')\')  as cate_path                   ';
		$sqlstr  .=   '  from tb_csluoman_pictype where show_type=\''.$show.'\'';
		$sqlstr  .=   '  UNION ALL';
		$sqlstr  .=   '  select CONCAT(series_id,series_type) as cate_Id,series_type as cate_ParentId,';
		$sqlstr  .=   '  IFNULL(concat(b.hotel_name,series_date),concat(series_theme,series_date)) as cate_Name,                                               ';
		$sqlstr  .=   '  concat(\'javascript:show_page(1,\\\'pic_series/\',series_id,\'\\\',\\\''.$url.'\\\')\')  as cate_Name                    ';
		$sqlstr  .=   '  from (select n.* from  tb_csluoman_picseries n,tb_csluoman_pictype m where n.series_type = m.pictype_id and m.show_type=\''.$show.'\' and series_status=1 order by n.series_order desc) a LEFT JOIN tb_csluoman_hotel b ';
		$sqlstr  .=   '  ON a.series_hotel=b.hotel_id';
			
		//$Model = new Model();// 实例化一个model对象 没有对应任何数据表
			
		//$leftmenulist=$Model->query($sqlstr);
		
		$leftmenulist = \think\Db::query($sqlstr);
			
		return $leftmenulist;
		 
	}
	
	public function test(){
	
		$data=3;
		
		echo '$data='.$data;
	
		return $data = (string) $data;
	}
	
	
	
	
}






?>