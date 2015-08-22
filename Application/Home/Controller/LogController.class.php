<?php

namespace Home\Controller;

use Think\Controller;

include_once DOC_ROOT . '/Application/Common/service/LoginService.class.php';

// 通用组件模块
class LogController extends Controller {
	public function index() {
		header ( "Content-Type:text/html; charset=utf-8" );
		$this->display ();
	}
	
	// 验证手机号是否被注册
	public function checkLoginId() {
		$callback = $_GET ["callback"];
		$mobile = $_GET ["mobile"];
		if (empty ( $callback ) || empty ( $mobile )) {
			return;
		}
		$search ='/^1[3|4|5|7|8][0-9]\d{4,8}$/';
	
		if(!preg_match($search,$mobile)) {
			$date->result=false;
			$date->reason="numberError";
			$this->ajaxReturn ( $date , 'JSONP' );
		}
		$date->result=true;
		$this->ajaxReturn ( $date , 'JSONP' );
	}
	
	public function checkout() {
		header ( "Content-Type:text/html; charset=utf-8" );
		\LoginService::checkout ();
		$this->success("退出成功","http://www.meipet.com.cn/");
	}
	public function doLog() {
		$mobile = $_POST ["mobile"];
		$password = $_POST ["password"];
		
		$logUrl = 'http://www.meipet.com.cn/index.php/Home/Log/index';
		
		$date->result=false;
		
		if (empty ( $mobile ) || empty ( $password )) {
			$date->reason="账号或密码为空";
			return $this->ajaxReturn ( $date , 'JSONP' );
		}
		
		$Dao = M ( "user" );
		$condition ['login_id'] = $mobile;
		$user = $Dao->where ( $condition )->find ();
		
		if (empty ( $user )) {
			$date->reason="该账号不存在";
			return $this->ajaxReturn ( $date , 'JSONP' );
		}
		
		$passwordMd5 = $user ["password"];
		
		if (md5 ( $password ) != $passwordMd5) {
			$date->reason="账号和密码错误";
			return $this->ajaxReturn ( $date , 'JSONP' );
		}
		
		// 登录成功,session赋值
		
		\LoginService::saveUser ( $user );
		$date->result=true;
		return $this->ajaxReturn ( $date , 'JSONP' );

	}
}
?>