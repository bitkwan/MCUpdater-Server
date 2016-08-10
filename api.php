<?php
require 'core/config.php';
header('Content-type: application/json; charset=utf-8');
$_json=file_get_contents("php://input");
if(@$_GET["token"]==$_token){
	$_json=json_decode($_json,TRUE);
	if($_json){
		$_mods=dir_list($_mods_dir);
		
		$x=-1;
		
		foreach ($_json as $value){
			$x=$x+1;
			$_post_arr[$x]=$value[0];
			unset($_json[$x][1]);
		}
		
		$x=-1;
		foreach ($_mods as $value){
			$x=$x+1;
			$_server_arr[$x]=$value[0];
			unset($_mods[$x][1]);
		}
		
		$result_dl=array_diff($_server_arr,$_post_arr);
		$result_del=array_diff($_post_arr,$_server_arr);
		#print($_server_arr);
		$x=-1;
		if($result_dl || $_result_del){
			@$_json_arr=["update"=>1,"down"=>$result_dl,"del"=>$result_del];
		}else{
			$_json_arr=["update"=>0];
		}
		
		print_r(json_encode($_json_arr));
	}else{
		echo "Json Error";
	}
}else{
	echo "Token Error";
}
