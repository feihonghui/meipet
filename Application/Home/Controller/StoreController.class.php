<?php
namespace Home\Controller;
use Think\Controller;

include_once DOC_ROOT . '/Application/Common/service/SmsService.class.php';

// 通用组件模块
class StoreController extends Controller {
	public function index() {
		header ( "Content-Type:text/html; charset=utf-8" );
		$userId = $_GET ["userId"];
		if(empty($userId)){
			$this->display();
			return;
		}
		
		$userDao = M ( "user" );
		$user = $userDao->where("id=".$userId)->find();
		//echo $userDao->getLastSql();
		if(empty($user)){
			$this->display ();
			return;
		}
		
		$storeDao = M ( "store" );
		$store=$storeDao->where("user_id=".$userId)->find();
		if(empty($store)){
			$this->display ();
			return;
		}
		$this->assign('store',$store);
		$this->assign('user',$user);
		$this->display ();
	}
	
	
	public function index() {
		header ( "Content-Type:text/html; charset=utf-8" );
		$userId = $_GET ["userId"];
		if(empty($userId)){
			$this->display();
			return;
		}
	
		$userDao = M ( "user" );
		$user = $userDao->where("id=".$userId)->find();
		//echo $userDao->getLastSql();
		if(empty($user)){
			$this->display ();
			return;
		}
	
		$storeDao = M ( "store" );
		$store=$storeDao->where("user_id=".$userId)->find();
		if(empty($store)){
			$this->display ();
			return;
		}
		$this->assign('store',$store);
		$this->assign('user',$user);
		$this->display ();
	}
}
?>