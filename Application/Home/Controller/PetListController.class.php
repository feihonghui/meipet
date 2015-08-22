<?php
namespace Home\Controller;
use Think\Controller;


// 通用组件模块
class PetListController extends Controller {
	public function index() {
		header ( "Content-Type:text/html; charset=utf-8" );
		$category = $_GET ["category"];
		$area = $_GET ["area"];
		$city = $_GET ["city"];
		$page = $_GET ["page"];
		$size = $_GET ["size"];
		
		
		
	}
	
}
?>