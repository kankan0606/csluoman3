<?php
// +----------------------------------------------------------------------
// +----------------------------------------------------------------------
// | zkk: 447077187@qq.com
// +----------------------------------------------------------------------

// 应用公共文件
/*
 ------------------------------------------------------
参数：
$str_cut    需要截断的字符串
$length     允许字符串显示的最大长度
程序功能：截取全角和半角（汉字和英文）混合的字符串以避免乱码
------------------------------------------------------
*/
function substr_cut($str_cut,$length)
{
		
	if (strlen($str_cut) > $length){

		$arr=StringToArray($str_cut);  //转换成数组
		$i=0;
		$l=0;

		while ($l<$length&&$i<count($arr)){
			$l=$l+strlen($arr[$i]);
			$i++;
		}

		$arr =array_slice($arr,0,$i);

		$str_cut=implode('',$arr).'..';

	}
		
	return $str_cut;
}
/**
 * 把字符串转成数组，支持汉字，只能是utf-8格式的
 * @param $str
 * @return array
 */

function StringToArray($str)
{
  
   
   
	$result = array();

	$len = strlen($str);

	$i = 0;
	//\think\Log::write('StringToArray---$str==='.$str);
	while($i < $len){
		//\think\Log::write('$i==='.$i);
		//\think\Log::write('StringToArray---$str['.$i.']==='.$str[$i]);
		$chr = ord($str[$i]);

		if($chr == 9 || $chr == 10 || (32 <= $chr && $chr <= 126)) {

			$result[] = substr($str,$i,1);

			$i +=1;

		}elseif(192 <= $chr && $chr <= 223){

			$result[] = substr($str,$i,2);

			$i +=2;

		}elseif(224 <= $chr && $chr <= 239){

			$result[] = substr($str,$i,3);

			$i +=3;

		}elseif(240 <= $chr && $chr <= 247){

			$result[] = substr($str,$i,4);

			$i +=4;

		}elseif(248 <= $chr && $chr <= 251){

			$result[] = substr($str,$i,5);

			$i +=5;

		}elseif(252 <= $chr && $chr <= 253){

			$result[] = substr($str,$i,6);

			$i +=6;

		}

	}

	return $result;

}
