<?php
/**
 * @author    feihonghui
 +------------------------------------------------------------------------------
 */
class SmsService {
	
	/**
	 * +----------------------------------------------------------
	 * 应用程序初始化
	 * +----------------------------------------------------------
	 * 
	 * @access public
	 *         +----------------------------------------------------------
	 * @return void +----------------------------------------------------------
	 */
	static public function saveMessage($mobile, $content) {
		$Dao = M ( "sms" );
		$data ["mobile"] = $mobile;
		$data ["content"] = $content;
		$data ["GMT_CREATE"] = date ( 'Y-m-d H:i:s', time () );
		
		// 写入数据
		$lastInsId = $Dao->add ( $data );
		return $lastInsId;
	}
}