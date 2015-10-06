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
		session(array('name'=>'login_id','expire'=>604800));
		session(array('name'=>'user_id','expire'=>604800));
		session ( 'login_id', $user ['login_id'] );
		session ( 'user_id', $user ['id'] );
	}
	static public function checkout() {
		session(array('name'=>'login_id','expire'=>604800));
		session(array('name'=>'user_id','expire'=>604800));
		session ( 'login_id', null );
		session ( 'user_id', null );
	}
	static public function getUserId() {
		return session ( 'user_id' );
	}
	static public function getLoginId() {
		return session ( 'login_id' );
	}
	static public function isLogin() {
		$loginId = LoginService::getLoginId ();
		if (empty ( $loginId )) {
			return FALSE;
		} else {
			return TRUE;
		}
	}
	
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
}