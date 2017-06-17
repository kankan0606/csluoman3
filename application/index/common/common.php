<?php
// +---------------------------------------------------------------------
// +----------------------------------------------------------------------
// | Author: zkk
// +----------------------------------------------------------------------
use \think\Config;
/*
 * 给标题加上关键字
* $result 查询的数据结果
* $len  控制页面显示长度   为null就不会限制长度
* $field 需要添加关键词的字段
*/
/**
 获取树形菜单
 *       $divId       样式id
 $dataSource  数据源
 $pId         父ID
 *       return html
 */
function getTree($divId,$dataSource,$pId,$topId)
{
	$html = '';
	$phpstart='';
	$startHtml='<ul>';
	if($pId ==$topId)
		$startHtml = '<ul id="'.$divId.'">';

	//log::write(count($dataSource));

	foreach($dataSource as $k => $v)
	{
		//log::write('$k='.$k.' $v='.$v);
		//log::write('$cate_ParentId ='.$v['cate_ParentId'].' $pId ='.$pId);
		if($v['cate_ParentId'] == $pId)
		{         //父亲找到儿子
			$pathstr=$v['cate_path']?$v['cate_path']:'#';
			$html .= '<li><a href="'.$pathstr.'" target="_self">'.$v['cate_Name'].'</a>';
			$html .= getTree('',$dataSource, $v['cate_Id'],$topId);
			$html = $html.'</li>';
		}
	}
	$endHtml ='</ul>';
	//log::write($html);//'/index.php/Case-index-id-2-color-5/</li>'
	return $html ? $startHtml.$html.$endHtml : $html ;
}




/*
 * 给标题加上关键字
* $result 查询的数据结果
* $len  控制页面显示长度   为null就不会限制长度
* $field 需要添加关键词的字段
*/
function addKeyForCaption($result,$len,$field){

	$keywords=explode(',',\think\Config::get('KEYWORD'));
	 
	$keyword=$keywords[1];
	//\think\Log::write('addKeyForCaption---$$result==='.(is_array($result)?'$result is array':'$result is not array'));
	 
	if(!empty($result)){
		 
		if(is_array($result)){
			
		//	\think\Log::write('----$result is array');
			
			
			foreach ($result as $k=>$v){

				if(is_array($v)){
					 
					if(!empty($result[$k][$field])){

						$str=$result[$k][$field];

						if(!empty($len)){
							 
							$str=substr_cut($str,$len);
						}

						if(\think\Config::get('ADDKEYWORD')){
							$result[$k][$field]=$keyword.'-'.$str;

						}else
							$result[$k][$field]=$str;
					}
					 
				}else{
					$str=$result[$field];
					if(!empty($len)){
						$str=substr_cut($str,$len);
					}
					 
					if(\think\Config::get('ADDKEYWORD')){
						$result[$field]=$keyword.'-'.$str;
					}
					return $result;

				}
			}


		}else{
			//\think\Log::write('----$result is  not  array');
			$str=$result;
			if(!empty($len)){
				$str=substr_cut($str,$len);
			}
			 
			if(\think\Config::get('ADDKEYWORD')){
				$result=$keyword.'-'.$str;
			}
			return $result;

		}
		 
		 

	}
	return $result;
	 
}


/*
 * 给内容加上关键字
* $result 查询的数据结果
* $len  控制页面显示长度   为null就不会限制长度
* $field 需要添加关键词的字段
*/
function addKeyForContent($result,$field){
	 
	if(!\think\Config::get('ADDKEYWORD')){
		return $result;
	}

	$keywords=explode(',',\think\Config::get('KEYWORD'));

	$keyword=$keywords[0];  //添加的关键字

	$l=4;//添加关键字的数量
	 
	$startStr='';
	 
	$endStr='';
	 
	$tag='</p>';

	if(!empty($result)){
		 
		if(is_array($result)){

			foreach ($result as $k=>$v){

				if(is_array($v)){

					if(!empty($result[$k][$field])){

						$str=$result[$k][$field];

						$startStr=substr($str, 5);

						$temp=$startStr.$endStr;

						if(strpos($temp,'/></p>',0)>-1){
								
							$i= strpos($str,$tag,0);
								
							if($i<2){

								$prestr=substr($str, 0,$i);

								$nexstr=substr($str,$i+strlen($tag));

								$str=$prestr.$tag.insert_str($nexstr,$keyword,$tag);

							}else{

								$str=insert_str($str,$keyword,$tag);
							}
								
						}else{
								
							$str=insert_str($str,$keyword,$tag);
						}


						$endStr=substr($result[$k][$field],-5);

						$result[$k][$field]=$str;

					}

				}else{
						

					$str=$result[$field];

					$startStr=substr($str, 5);
						
					$temp=$startStr.$endStr;
						
					if(strpos($temp,'/></p>',0)>-1){
							
						$i= strpos($str,$tag,0);
							
						if($i<2){
								
							$prestr=substr($str, 0,$i);
								
							$nexstr=substr($str,$i+strlen($tag));
								
							$str=$prestr.$tag.insert_str($nexstr,$keyword,$tag);
								
						}else{
								
							$str=insert_str($str,$keyword,$tag);
						}
							
					}else{
							
						$str=insert_str($str,$keyword,$tag);
					}
						
						
					$endStr=substr($result[$field],-5);
						
					$result[$field]=$str;

				}
				 
			}
			return $result;
		}else{

			return insert_str($result,$keyword,$tag);

		}
		 
		 

	}
	return null;

}

/**
 * 添加字符串
 * @param unknown_type $str  需要添加字符串的字符串
 * @param unknown_type $replaceStr  添加字符串的内容
 * @param unknown_type $tag  标识
 * @return string|unknown
 */
function insert_str($str,$replaceStr,$tag){

    $i= strpos($str,$tag,0);

    if($i>-1){  //找到指定标签
        	
        $prestr=trim(substr($str, 0,$i));
        	
        $rest = substr($prestr, -2);
        	
        if($rest!='/>'){
            $prestr=$prestr.'  <'.$replaceStr.'>';
        }
        	
        $nexstr=substr($str,$i+strlen($tag));
        	
        $nexstr=insert_str($nexstr,$replaceStr,$tag);
        	
        return $prestr.$tag.$nexstr;
        	
    }else{
        	
        return $str;
    }

}



?>