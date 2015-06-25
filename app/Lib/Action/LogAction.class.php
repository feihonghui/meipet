<?php
require_once DOC_ROOT . '\app\Lib\service\LoginService.class.php';
// 通用组件模块
class LogAction extends Action {
	public function index() {
		header ( "Content-Type:text/html; charset=utf-8" );
		$this->display ();
	}
	
	public function doLog() {
		$mobile = $_POST ["mobile"];
		$password = $_POST ["password"];
	
		$logUrl = 'http://www.meipet.com.cn/index.php/Log/index';
	
		if (empty ( $mobile )||empty ( $password )) {
			$this->error ( "字段不能为空", $logUrl );
			return;
		}
		
		$Dao = M ( "user" );
		$condition ['login_id'] = $mobile;
		$user = $Dao->where ( $condition )->find ();
		
		if (empty ( $user )) {
			$this->error ( "该账号不存在", $logUrl );
			return;
		} 
	
		$passwordMd5=$user["password"];
	
		if(md5($password)!=$passwordMd5){
			$this->error ( "账号或密码错误", $logUrl );
			return;
		}
	
		//登录成功,session赋值
		LoginService::saveUser($user);
	
		// 写入数据
		echo $this->success("","http://www.meipet.com.cn"); 
	}
	
}
?>