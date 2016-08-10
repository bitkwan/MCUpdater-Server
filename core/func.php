<?php
function dir_path($path) { 
	$path = str_replace('\\', '/', $path); 
	if (substr($path, -1) != '/') $path = $path . '/'; 
	return $path; 
} 

/** 
* �г�Ŀ¼�µ������ļ� 
* 
* @param str $path Ŀ¼ 
* @param str $exts ��׺ 
* @param array $list ·������ 
* @return array ����·������ 
*/ 
function dir_list($path, $exts = '', $list = array()) { 
	$path = dir_path($path); 
	$files = glob($path . '*'); 
	foreach($files as $v) { 
		if (!$exts || preg_match("/\.($exts)/i", $v)) { 
			$v=str_replace($path,"",$v);
			$list[] = [0=>md5_file($path.$v),1=>$v]; 
			if (is_dir($v)) { 
				$list = dir_list($v, $exts, $list); 
			} 
		} 
	} 
	return $list; 
} 
function array_diff_assoc_recursive($array1,$array2){
    $diffarray=array();
	$x=0;
    foreach ($array1 as $value) { 
		$x=$x+1;
		if (!in_array($value, $array2)) { 
			$diffarray[$x]=$value;
		} 
	}
    return $diffarray;  
}


function unicode_encode($name){
 $name = iconv('UTF-8', 'UCS-2', $name);
 $len = strlen($name);
 $str = '';
 //for ($i = 0; $i < $len �C 1; $i = $i + 2){
 for($i=0;$i<$len-1;$i=$i+2){
  $c = $name[$i];
  $c2 = $name[$i + 1];
  if (ord($c) > 0){    // �����ֽڵ�����
   $str .= '\u'.base_convert(ord($c), 10, 16).base_convert(ord($c2), 10, 16);
  }else{
   $str .= $c2;
  }
 }
 return $str;
}