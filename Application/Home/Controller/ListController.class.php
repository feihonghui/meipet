<?php
namespace Home\Controller;
use Think\Controller;


// 通用组件模块
class ListController extends Controller {
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
		
		$petList = $Dao->where ( $condition )->limit($limit)->select();
	    //echo 	$Dao->getLastSql();
		$data->result = true;
	    $data->data=$petList;
		$this->ajaxReturn($data,"JSONP");
	}
}
?>