<?php
require_once DOC_ROOT . '\app\Lib\service\SmsService.class.php';
// 通用组件模块
class RegAction extends Action {
	public function index() {
		header ( "Content-Type:text/html; charset=utf-8" );
		// echo "第一个例子测试！";
		// $info='这里是网页头部mpbar';
		// $this->assign( "info", $info );
		// 输出模板
		$this->display ();
	}
	
	// 获取验证码
	public function Verifycode() {
		$callback = $_GET ["callback"];
		$mobile = $_GET ["mobile"];
		if (empty ( $mobile )) {
			return;
		}
		
		if ($this->hasSended ( $mobile )) {
			return;
		}
		$code = rand ( 100000, 999999 );
		
		$content = "您的注册验证码为:" . $code . "，请于30分钟内正确输入验证码";
		
		// 发送短信
		// sent($mobile,$content)
		$id = SmsService::saveMessage ( $mobile, $content );
		echo "id:" . $id;
		$data = $code;
		if (empty ( $callback )) {
			// json
			$this->ajaxReturn ( $data, 'info:' . $mobile, 1, 'JSON' );
		} else {
			$this->ajaxReturn ( $data, 'info:' . $mobile, 1, 'JSONP', $callback );
		}
	}
	public function mpbottom() {
		header ( "Content-Type:text/html; charset=utf-8" );
		$info = '这里是网页底部mpbottom';
		$this->assign ( "info", $info );
		// 输出模板
		$this->display ();
	}
	private function hasSended($mobile) {
		$Dao = M ( "sms" );
		$condition ['mobile'] = $mobile;
		$list = $Dao->where ( $condition )->order ( 'GMT_CREATE DESC' )->limit ( '0,1' )->select ();
		
		if (empty ( $list )) {
			return FALSE;
		}
		
		$cur = strtotime ( date ( 'y-m-d h:i:s' ) ); // 当前时间
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