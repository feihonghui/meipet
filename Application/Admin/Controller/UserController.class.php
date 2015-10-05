<?php
// 本类由系统自动生成，仅供测试用途
namespace Admin\Controller;

use Think\Controller;

include_once DOC_ROOT . '/Application/Common/service/LoginService.class.php';
class UserController extends AdminBaseController {
	protected $userinfo = "http://www.meipet.com.cn/index.php/Admin/User/info";
	public function info() {
		if (! \LoginService::isLogin ()) {
			$this->error ( "请登录！", $this->loginUrl );
		}
		
		$user = \LoginService::getUserModel ();
		$userId=$user["id"];
		$Dao = M ( "User" );
		$user=$Dao->where("id=".$userId)->find();
		
		$this->assign ( "user", $user );
		$this->assign ( "user_sex", $user ['sex'] );
		$this->assign ( "generation", $user ['generation'] );
		// 输出模板
		$this->display ();
	}
	public function update() {
		header ( "Content-Type:text/html; charset=utf-8" );
		if (! \LoginService::isLogin ()) {
			$this->error ( "请登录！", $this->loginUrl );
		}
		\LoginService::getUserModel ();
		
		$Dao = D ( "User" );
		if ($Dao->create ()) {
			$Dao->gmt_modified = date ( 'Y-m-d H:i:s', time () );
			if (\LoginService::getUserId () != $Dao->id) {
				echo "修改失败,id被人为修改,";
				return;
			}
			$result = $Dao->save ();
			if ($result) {
				$this->success ( "修改成功", "$userinfo" );
			} else {
				$this->error ( "系统错误", "$userinfo" );
			}
		} else {
			exit ( $Dao->getError () . ' [ <a href="javascript:history.back()">返 回</a> ]' );
		}
	}
}