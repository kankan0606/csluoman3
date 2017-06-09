<?php
namespace app\index\controller;

class Index extends BaseController
{
    public function index()
    {

    	$newlist=\think\Db::name('caption')
					->where('c_type',1)
					->order('c_date desc')
					->limit(8)
					->select();
    	
    	$whlist=\think\Db::name('caption')
					->where('c_type',2)
					->whereOr('c_type',3)
					->order('c_date desc')
					->limit(8)
					->select();
    	$strlen =20;
    	$newlist  = addKeyForCaption($newlist,$strlen,'c_name');
    	$whlist   = addKeyForCaption($whlist,$strlen,'c_name');
    	
      $this->assign(['newlist'=>$newlist,
       		          'whlist'=>$whlist,
       		        ]);
    
        return $this->fetch();
    }
    
  
}
