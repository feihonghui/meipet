<?php
namespace Home\Controller;
use Think\Controller;

include_once DOC_ROOT . '/Application/Common/service/SmsService.class.php';

// 通用组件模块
class ForgetController extends Controller {
	public function index() {
		header ( "Content-Type:text/html; charset=utf-8" );
		$this->display ();
	}
	
	// 找回密码
	public function getPassword() {
		$mobile = $_POST ["mobile"];
		$password = $_POST ["password"];
		$password2 = $_POST ["password2"];
		$yanzhengma = $_POST ["yanzhengma"];
		
	    if (empty ( $mobile ) || empty ( $password ) || empty ( $password2 ) || empty ( $yanzhengma )) {
			return $this->ajaxReturn ( $this->failJson ( "字段不能为空" ), "JSONP" );
		}
	
		if ($password != $password2) {
			return $this->ajaxReturn ( $this->failJson ( "密码不一致" ), "JSONP" );
		}
		
		$Dao = M ( "user" );
		$condition ['login_id'] = $mobile;
		$user = $Dao->where ( $condition )->find ();
		
		if (empty ( $user )) {
			return $this->ajaxReturn ( $this->failJson ( "账号不存在" ), "JSONP" );
		}
		
		$oldcode = S ( "verifycode_" . $mobile );
		if ($yanzhengma != $oldcode) {
			return $this->ajaxReturn ( $this->failJson ( "验证码不正确" ), "JSONP" );
		}
		
		$user ["password"] = md5 ( $password );
		$user ["gmt_modified"] = date ( 'Y-m-d H:i:s', time () );
		
		
		
		$cond ['id'] = $user ['id'];
		$result = $Dao->where ( $cond )->save ( $user );
		
		//echo $Dao->getLastSql();
		
		 if ($result !== false) {
		 	return $this->ajaxReturn ( $this->successJson (), "JSONP" );
		} else {
			return $this->ajaxReturn ( $this->failJson ( "数据写入错误" ), "JSONP" );
		} 
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