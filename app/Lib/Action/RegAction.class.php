<?php
require_once DOC_ROOT . '\app\Lib\service\SmsService.class.php';
// 通用组件模块
class RegAction extends Action {
	public function index() {
		header ( "Content-Type:text/html; charset=utf-8" );
		$this->display ();
	}
	public function forget() {
		header ( "Content-Type:text/html; charset=utf-8" );
		$this->display ();
	}
	public function doReg() {
		$mobile = $_POST ["mobile"];
		$password = $_POST ["password"];
		$password2 = $_POST ["password2"];
		$yanzhengma = $_POST ["yanzhengma"];
		
		$regUrl = 'http://www.meipet.com.cn/index.php/Reg/index';
		
		if (empty ( $mobile ) || empty ( $password ) || empty ( $password2 ) || empty ( $yanzhengma )) {
			$this->error ( "字段不能为空", $regUrl );
			return;
		}
		
		if ($this->isExistLoginId ( $mobile )) {
			$this->error ( "该账号已经被注册", $regUrl );
			return;
		}
		
		if ($password != $password2) {
			$this->error ( "密码不一致", $regUrl );
			return;
		}
		
		$oldcode = S ( "verifycode_" . $mobile );
		if ($yanzhengma != $oldcode) {
			$this->error ( "验证码不对", $regUrl );
			return;
		}
		
		$Dao = M ( "user" ); // 实例化模型类
		                     
		// 构建写入的数据数组
		$data ["login_id"] = $mobile;
		$data ["mobile"] = $mobile;
		$data ["password"] = md5 ( $password );
		$data ["mobile"] = $mobile;
		$data ["GMT_CREATE"] = date ( 'Y-m-d H:i:s', time () );
		$data ["gmt_modified"] = date ( 'Y-m-d H:i:s', time () );
		
		// 写入数据
		if ($lastInsId = $Dao->add ( $data )) {
			echo $this->success ( "", "http://www.meipet.com.cn/index.php/Log/index" );
		} else {
			$this->error ( '数据写入错误！', $regUrl );
		}
	}
	
	// 找回密码
	public function getPassword() {
		$mobile = $_POST ["mobile"];
		$password = $_POST ["password"];
		$password2 = $_POST ["password2"];
		$yanzhengma = $_POST ["yanzhengma"];
		
		$forgetUrl = 'http://www.meipet.com.cn/index.php/Reg/forget';
		
		if (empty ( $mobile ) || empty ( $password ) || empty ( $password2 ) || empty ( $yanzhengma )) {
			$this->error ( "字段不能为空", $forgetUrl );
			return;
		}
		
		$Dao = M ( "user" );
		$condition ['login_id'] = $mobile;
		$user = $Dao->where ( $condition )->find ();
		
		if (empty ( $user )) {
			$this->error ( "该账号不存在", $forgetUrl );
			return;
		}
		
		if ($password != $password2) {
			$this->error ( "密码不一致", $forgetUrl );
			return;
		}
		
		$oldcode = S ( "verifycode_" . $mobile );
		if ($yanzhengma != $oldcode) {
			$this->error ( "验证码不对", $forgetUrl );
			return;
		}
		
		$user ["password"] = md5 ( $password );
		$user ["gmt_modified"] = date ( 'Y-m-d H:i:s', time () );
		
		$cond ['id'] = $user ['id'];
		$result = $Dao->where ( $cond )->save ( $user );
		
		//echo $Dao->getLastSql();
		
		 if ($result !== false) {
			
			echo $this->success ( "", "http://www.meipet.com.cn/index.php/Log/index" );
			return;
		} else {
			$this->error ( "系统错误", $forgetUrl );
			return;
		} 
	}
	
	// 验证手机号是否被注册
	public function checkLoginId() {
		$callback = $_GET ["callback"];
		$mobile = $_GET ["mobile"];
		if (empty ( $callback ) || empty ( $mobile )) {
			return;
		}
		
		if (! $this->isExistLoginId ( $mobile )) {
			$this->ajaxReturn ( true, $mobile . ' is ok!:', 1, 'JSONP', $callback );
		} else {
			$this->ajaxReturn ( false, $mobile . ' has exist!:', 1, 'JSONP', $callback );
		}
	}
	
	// 获取验证码
	public function Verifycode() {
		$callback = $_GET ["callback"];
		$mobile = $_GET ["mobile"];
		if (empty ( $callback ) || empty ( $mobile )) {
			return;
		}
		
		if ($this->hasSended ( $mobile )) {
			return;
		}
		$code = rand ( 100000, 999999 );
		
		$content = "您的注册验证码为:" . $code . "，请于30分钟内正确输入验证码";
		// 发送短信
		// sent($mobile,$content)
		// 本地缓存
		S ( "verifycode_" . $mobile, $code, 1800 );
		
		// 记录短信
		$id = SmsService::saveMessage ( $mobile, $content );
		
		$this->ajaxReturn ( $content, 'info:' . $mobile, 1, 'EVAL', $callback );
	}
	private function isExistLoginId($mobile) {
		$Dao = M ( "user" );
		$condition ['login_id'] = $mobile;
		$list = $Dao->where ( $condition )->find ();
		
		if (empty ( $list )) {
			return false;
		} else {
			return true;
		}
	}
	private function hasSended($mobile) {
		$Dao = M ( "sms" );
		$condition ['mobile'] = $mobile;
		$list = $Dao->where ( $condition )->order ( 'GMT_CREATE DESC' )->limit ( '0,1' )->select ();
		
		if (empty ( $list )) {
			return FALSE;
		}
		
		$cur = strtotime ( date ( 'y-m-d H:i:s' ) ); // 当前时间
		$lasttime = strtotime ( $list [0] ['GMT_CREATE'] ); // 短信时间
		$interval = ($cur - $lasttime); // 60s*60min*24h
		                                // 验证码过期时间半小时
		
		if ($interval > 30 * 60) {
			return false;
		}
		return TRUE;
	}
}
?>