<?php
namespace Home\Controller;
use Think\Controller;


// 通用组件模块
class FreelistController extends Controller {
	public function index() {
		header ( "Content-Type:text/html; charset=utf-8" );
		$this->display();
	}
	
	public function getPet() {
		header ( "Content-Type:text/html; charset=utf-8" );
		$category = $_GET ["category"];
		$area = $_GET ["area"];
		$city = $_GET ["city"];
		$page = $_GET ["page"];
		$size = $_GET ["size"];
		
		if(empty($page)){
			$page=1;
		}
		if(empty($size)){
		    $size=20;
		}
		
		$limit=($page-1)*$size.",".$size;
		
		
		$Dao = M ( "pet" );
		if(!empty($category)){
			$condition ['category'] = $category;
		}
		if(!empty($area)){
		   $condition ['area'] = $area;
		}
		if(!empty($city)){
			$condition ['city'] = $city;
		}

		$condition ['price'] = 0;
		$condition ['status']="open";
		
		$petList = $Dao->where ( $condition )->order("gmt_modified desc")->limit($limit)->select();
		//echo  $Dao->getLastSql();
		$array = array();
		if(!empty($petList)){
			foreach ($petList as $pet){
				$pet['month']=floor((time()-strtotime($pet['birthday']))/3600/24/30);
				array_push($array, $pet);
			}
		}
	    //echo 	$Dao->getLastSql();
		$data->result = true;
	    $data->data=$array;
		$this->ajaxReturn($data,"JSONP");
	}
}
?>