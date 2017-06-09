<?php
// +----------------------------------------------------------------------
// | ThinkPHP
// +-----------------------------------------------------------
// +----------------------------------------------------------------------
// | Author: zkk
// +----------------------------------------------------------------------
// $Id$
namespace app\index\controller;
use \think\Request,\think\Log;

class BaseController extends \think\Controller
{
	public function __construct(Request $request = null){		 
		
		if (is_null($request)) {
			$request = Request::instance();
		}
		
		$base    = $request->root();
		 
		$root    = strpos($base, '.') ? ltrim(dirname($base), DS) : $base;

		if ('' != $root) {
			$root = '/' . ltrim($root, '/');
		}
		
		\think\Config::set([
				'view_replace_str'       => [
				'__JS__'     => $root.'/static/home/js', // 增加新的JS类库路径替换规则
				'__UPLOAD__' => $root.'/static/home/upload', // 增加新的上传路径替换规则
				'__IMAGES__' => $root.'/static/home/images', // 增加新的上传路径替换规则
				'__FLASH__'  => $root.'/static/home/flash',
				'__CSS__'    => $root.'/static/home/css',
				],
				]);
		
		parent::__construct($request);
		
		
	    
	}
	public function _initialize(){
		
		    //导航栏
		    
		    $menu = new \app\index\model\Menu();
		    
		    
			$menulist=$menu->where('status','1')
							->where('level',1)
							->order('order_key')
							->select();
						
			$menuid = $this->request->has('menuid')? $this->request->param('menuid'):'';			
			
			$leftmenulist=  $this->get_leftmenu($menuid);
			
			//log::write('leftmenulist count in class baseaction _initialize : '.count($leftmenulist));
			
			
			$this->assign(array(
					'title'  => '罗蔓官网|'.\think\Config::get('TITLE'),
					'keywords'=>'长沙婚庆,湖南婚庆,长沙婚庆公司,长沙婚礼策划,长沙最好的婚庆公司,长沙婚礼策划公司,长沙庆典策划公司,罗蔓婚庆公司',
					'description'=>'罗蔓婚庆打造个性首选的婚庆公司策划团队,长沙最好的婚庆策划品牌、资深策划、满意百分百婚礼策划、主持、布置、婚车、化妆、摄影、酒店预订一条龙服务。电话：0731-84221468。',
					'navigation'  => $menulist,    // 导航
					'list'  => $leftmenulist,     // 导航
					 'menuid'  => $menuid,      // 导航
			        // 'urlstr'   =>  
			));
		
	}
	
	public function get_leftmenu($id){
		 
		if(!empty($id)){
			
			$map['upmenu_id'] = ['eq',$id];
			$map['status'] = ['eq','1'];
			$map['level'] = ['gt',1];
			// 把查询条件传入查询方法
			
			$menu = new \app\index\model\Menu();
			                    
			
			$menulist=$menu->field('menu_id as cate_Id,upmenu_id as cate_ParentId,path as cate_path,name as cate_Name')
			                    ->where($map)
			                    ->order('order_key asc')
			                    ->select();
			
			return $menulist;
			 
		}else{
	
			return null;
		}
		 
	}
}