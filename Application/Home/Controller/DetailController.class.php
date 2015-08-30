<?php
namespace Home\Controller;
use Think\Controller;

import('ORG.Util.Date');

// 通用组件模块
class DetailController extends Controller {
	public function index() {
		header ( "Content-Type:text/html; charset=utf-8" );
		$id = $_GET ["id"];
		if(empty($id)){
			header("location: http://www.meipet.com.cn");
			return;
		}
		$Dao = M ( "pet" );
		$pet = $Dao->where("id=".$id)->find();
		
		if(empty($pet)){
			$this->display();
			return;
		}
		
		$userId=$pet["user_id"];
		$userDao = M ( "user" );
		$user = $userDao->where("id=".$userId)->find();
		if(!empty($user)){
			//echo $imgDao->getLastSql();
			$this->assign('user',$user);
		}
		
		$imgDao = M ( "pet_img" );
		$imgList = $imgDao->where("pet_id=".$id)->select();
		 
		if(!empty($imgList)){
			//echo $imgDao->getLastSql();
		    $this->assign('imgList',$imgList);
		}
		$this->assign('pet',$pet);
		
		$birthday=date("Y-m-d",$pet->birthday);
		$this->assign('birthday',$birthday);
		
		$price="".$pet["price"]/100;
		$this->assign('price',$price);
		$this->display();
	}
	
}
?>