<?php
/**
 * @author    feihonghui
 +------------------------------------------------------------------------------
 */
class SmsService {
	protected static $name = "13777427154";
	protected static $pwd = "BC6B7ACA7D2920EAEB0C2C0659EB";
	protected static $sign = "美优萌宠";
	static public function getUserModel() {
		$loginId = LoginService::getLoginId ();
		if (empty ( $loginId )) {
			return null;
		}
		
		$Dao = M ( "user" );
		$condition ['login_id'] = $loginId;
		$user = $Dao->where ( $condition )->find ();
		return $user;
	}
	static public function sent($mobile, $content) {
		$flag = 0;
		$params = ''; // 要post的数据
		$argv = array (
				'name' => self::$name, // 必填参数。用户账号
				'pwd' => self::$pwd, // 必填参数。（web平台：基本资料中的接口密码）
				'content' => $content, // 必填参数。发送内容（1-500 个汉字）UTF-8编码
				'mobile' => $mobile, // 必填参数。手机号码。多个以英文逗号隔开
				'stime' => '', // 可选参数。发送时间，填写时已填写的时间发送，不填时为当前时间发送
				'sign' => self::$sign, // 必填参数。用户签名。
				'type' => 'pt', // 必填参数。固定值 pt
				'extno' => '' 
		);
		foreach ( $argv as $key => $value ) {
			if ($flag != 0) {
				$params .= "&";
				$flag = 1;
			}
			$params .= $key . "=";
			$params .= urlencode ( $value ); // urlencode($value);
			$flag = 1;
		}
		$url = "http://web.duanxinwang.cc/asmx/smsservice.aspx?" . $params; // 提交的url地址
		//echo $url;
		$result=file_get_contents ( $url );
		//echo $result;
		$con = substr ($result, 0, 1 ); // 获取信息发送后的状态
		
		if ($con == '0') {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}