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
		
		$forgetUrl = 'http://www.meipet.com.cn/index.php/Home/Reg/forget';
		
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
			
			echo $this->success ( "", "http://www.meipet.com.cn/index.php/Home/Log/index" );
			return;
		} else {
			$this->error ( "系统错误", $forgetUrl );
			return;
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
		$content = "亲爱的小主银，您的注册验证码是" . $code . "（30分钟内有效）。您就是我的全世界，么么哒~";
		// 发送短信
		if(\SmsService::sent($mobile, $content)){
			S ( "verifycode_" . $mobile, $code, 1800 );
			// 记录短信
			$id = $this->saveMessage ( $mobile, $content );
			$this->ajaxReturn ( "success", 'JSONP' );
		}
		$this->ajaxReturn ( "false", 'JSONP' );
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
    private function saveMessage($mobile, $content) {
		$Dao = M ( "sms" );
		$data ["mobile"] = $mobile;
		$data ["content"] = $content;
		$data ["GMT_CREATE"] = date ( 'Y-m-d H:i:s', time () );
	
		// 写入数据
		$lastInsId = $Dao->add ( $data );
		return $lastInsId;
	}
}
?>