<?php
// 本类由系统自动生成，仅供测试用途
namespace Admin\Controller;

use Think\Controller;

include_once DOC_ROOT . '/Application/Common/service/LoginService.class.php';
class ShopController extends AdminBaseController {
	protected $userinfo = "http://www.meipet.com.cn/index.php/Admin/User/info";
	public function open() {
		if (! \LoginService::isLogin ()) {
			$this->error ( "请登录！", $this->loginUrl );
		}
		
		$user = \LoginService::getUserModel ();
		$this->assign ( "user", $user );
		// 输出模板
		$this->display ();
	}
	
	public function set() {
		if (! \LoginService::isLogin ()) {
			$this->error ( "请登录！", $this->loginUrl );
		}
	
		$user = \LoginService::getUserModel ();
		$this->assign ( "user", $user );
		$userId=$user["id"];
		$Dao = M ( "store" );
		$store=$Dao->where("user_id=".$userId)->find();
	
		$this->assign ( "store", $store );
		// 输出模板
		$this->display ();
	}
	
}