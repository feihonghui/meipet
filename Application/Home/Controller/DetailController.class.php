<?php
namespace Home\Controller;
use Think\Controller;

import('ORG.Util.Date');
include_once DOC_ROOT . '/Application/Common/service/LoginService.class.php';
include_once DOC_ROOT . '/Application/Common/service/HtmlRenderService.class.php';
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
	
	//用户名称，联系方式，
	public  function adopt() {
		$petid = $_GET ["petid"];
		if(empty($petid)){
			$this->ajaxReturn ( \HtmlRenderService::errorJson("param_error"), "JSONP" );
		}
		
		if (! \LoginService::isLogin ()) {
			$this->ajaxReturn ( \HtmlRenderService::errorJson("not_login"), "JSONP" );
		}
		
		$Dao = M ( "pet" );
		$pet=$Dao->where (" id= ".$petid) ->find();
		if(empty($pet)){
			$this->ajaxReturn ( \HtmlRenderService::errorJson("pet_not_exist"), "JSONP" );
		}
		
		
		$userDao = M ( "user" );
		$seller=$userDao->where (" id= ".$pet['user_id']) ->find();
	
		$resutl["phone"]=$seller["login_id"];
		$resutl["address"]=$pet["city"].$pet["area"].$pet["address"];
		return $this->ajaxReturn ( \HtmlRenderService::successJson($resutl), "JSONP" );
	}
	
}
?>