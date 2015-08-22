<?php

namespace Home\Controller;

use Think\Controller;

include_once DOC_ROOT . '/Application/Common/service/SmsService.class.php';

// 通用组件模块
class RegController extends Controller {
	public function index() {
		header ( "Content-Type:text/html; charset=utf-8" );
		$this->display ();
	}
	public function doReg() {
		$mobile = $_POST ["mobile"];
		$password = $_POST ["password"];
		$password2 = $_POST ["password2"];
		$yanzhengma = $_POST ["yanzhengma"];
		
		$regUrl = 'http://www.meipet.com.cn/index.php/Home/Reg/index';
		
		if (empty ( $mobile ) || empty ( $password ) || empty ( $password2 ) || empty ( $yanzhengma )) {
			return $this->ajaxReturn ( $this->failJson ( "字段不能为空" ), "JSONP" );
		}
		
		if ($this->isExistLoginId ( $mobile )) {
			return $this->ajaxReturn ( $this->failJson ( "该账号已经被注册" ), "JSONP" );
		}
		
		if ($password != $password2) {
			return $this->ajaxReturn ( $this->failJson ( "密码不一致" ), "JSONP" );
		}
		
		$oldcode = S ( "verifycode_" . $mobile );
		if ($yanzhengma != $oldcode) {
			return $this->ajaxReturn ( $this->failJson ( "验证码不正确" ), "JSONP" );
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
			return $this->ajaxReturn ( $this->successJson (), "JSONP" );
		} else {
			return $this->ajaxReturn ( $this->failJson ( "数据写入错误" ), "JSONP" );
		}
	}
	
	// 验证手机号是否被注册
	public function checkLoginId() {
		$callback = $_GET ["callback"];
		$mobile = $_GET ["mobile"];
		if (empty ( $callback ) || empty ( $mobile )) {
			return;
		}
		$search = '/^1[3|4|5|7|8][0-9]\d{4,8}$/';
		
		if (! preg_match ( $search, $mobile )) {
			$date->result = false;
			$date->reason = "numberError";
			$this->ajaxReturn ( $date, 'JSONP' );
		}
		
		if (! $this->isExistLoginId ( $mobile )) {
			$date->result = true;
			$this->ajaxReturn ( $date, 'JSONP' );
		} else {
			$date->result = false;
			$date->reason = "numberExist";
			$this->ajaxReturn ( $date, 'JSONP' );
		}
	}
	
	// 获取验证码
	public function Verifycode() {
		$callback = $_GET ["callback"];
		$mobile = $_GET ["mobile"];
		if (empty ( $callback ) || empty ( $mobile )) {
			return $this->ajaxReturn ( $this->failJson ( "手机号为空" ), 'JSONP' );
		}
		
		if ($this->hasSended ( $mobile )) {
			$date = $this->successJson ();
			$date->reason = "hasSended";
			return $this->ajaxReturn ( $date, 'JSONP' );
		}
		$code = rand ( 100000, 999999 );
		$content = "亲爱的小主银，您的注册验证码是" . $code . "（30分钟内有效）。您就是我的全世界，么么哒~";
		// 发送短信
		if (\SmsService::sent ( $mobile, $content )) {
			S ( "verifycode_" . $mobile, $code, 1800 );
			// 记录短信
			$id = $this->saveMessage ( $mobile, $content );
			$this->ajaxReturn ( $this->successJson (), 'JSONP' );
		}
		$this->ajaxReturn ( $this->failJson("SystemError"), 'JSONP' );
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