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
			header("location: http://www.meipet.com.cn");
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
	
	
	public function getPet() {
		header ( "Content-Type:text/html; charset=utf-8" );
		$userId = $_GET ["userId"];
		$adoptId = $_GET ["adoptId"];
		$page = $_GET ["page"];
		$size = $_GET ["size"];

	    if(empty($page)){
			$page=1;
		}
		if(empty($size)){
			$size=20;
		}
		
		$limit=($page-1)*$size.",".$size; 
		
		
	    if(empty($userId)&&empty($adoptId)){
	    	return $this->ajaxReturn ( $this->failJson ( "参数错误" ), "JSONP" );
	    }
		$petDao = M ( "pet" );
		
		if(!empty($userId)){
		    $cond ['user_id'] = $userId;
		}
		if(!empty($adoptId)){
			$cond ['adopt_id'] = $adoptId;
		}
		
		$petList = $petDao->where($cond)->limit($limit)->select();

		$data->result = true;
	    $data->data=$petList;
		$this->ajaxReturn($data,"JSONP"); 
	}
	
	protected function failJson($reason) {
		$date->result = false;
		$date->reason = $reason;
		return $date;
	}
	protected function successJson() {
		$date->result = true;
		return $date;
	}
}
?>