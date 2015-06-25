<?php
/**
 * @author    feihonghui
 +------------------------------------------------------------------------------
 */
class LoginService {
	
	/**
	 * +----------------------------------------------------------
	 * 应用程序初始化
	 * +----------------------------------------------------------
	 * 
	 * @access public
	 *         +----------------------------------------------------------
	 * @return void +----------------------------------------------------------
	 */
	static public function saveUser($user) {
		session('login_id',$user['login_id']);
		session('user_id',$user['id']);
	}
	
	static public function getUserId() {
		return session('user_id');
	}
	
	static public function getLoginId() {
		return session('login_id');
	}
}