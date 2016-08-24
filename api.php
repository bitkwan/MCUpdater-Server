<?php
require 'core/config.php';
header('Content-type: application/json; charset=utf-8');
$_json=file_get_contents("php://input");
if(@$_GET["token"]==$_token){
	if($_json){
		$_json=json_decode($_json,TRUE);
		$_mods=dir_list($_mods_dir);
		if(!$_json){
			$x=-1;
			$_server_list=[];
			
			foreach ($_mods as $value){
				$x=$x+1;
				$_ext=explode(".",$_mods[$x][1]);
				@$_ext=end($_ext);
				$_server_list[$_mods[$x][1]]=$value[0];
				$_server_arr[$x]=$value[0];
				$_server_exts[$value[0]]=$_ext;
				unset($_mods[$x][1]);
			}
			$x=-1;
			foreach($_server_list as $data){
				$x=$x+1;
				$_filename=array_search($data,$_server_list);
				$_ext=explode(".",$_filename);
				$result_dls[$x]=[0=>end($_ext),1=>$_dl_server.$_filename];
			}
			@$_json_arr=["update"=>1,"down_total"=>count($result_dls),"down"=>$result_dls,"del"=>false];
		}else{
			$x=-1;
			
			foreach ($_json as $value){
				$x=$x+1;
				$_post_arr[$x]=$value[0];
				unset($_json[$x][1]);
			}
			
			$x=-1;
			$_server_list=[];
			
			foreach ($_mods as $value){
				$x=$x+1;
				$_ext=explode(".",$_mods[$x][1]);
				@$_ext=end($_ext);
				$_server_list[$_dl_server.$_mods[$x][1]]=$value[0];
				$_server_arr[$x]=$value[0];
				$_server_exts[$value[0]]=$_ext;
				unset($_mods[$x][1]);
			}
			
			$result_dl=array_diff($_server_arr,$_post_arr);
			$result_del=array_diff($_post_arr,$_server_arr);
			$x=-1;
			foreach($result_dl as $data){
				$x=$x+1;
				$result_dls[$x]=[0=>$_server_exts[$data],1=>array_search($data,$_server_list)];
			}
			
			$x=-1;
			foreach($result_del as $data){
				$x=$x+1;
				$result_dels[$x]=$data;
			}
			
			if(@$result_dl || @$_result_del){
				@$_json_arr=["update"=>1,"down_total"=>count($result_dls),"down"=>$result_dls,"del"=>$result_dels];
			}else{
				$_json_arr=["update"=>0];
			}
		}
	}else{
		$_json_arr=["update"=>-1];
	}
}else{
	$_json_arr=["update"=>-2];
}


print_r(json_encode($_json_arr));