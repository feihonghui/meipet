<?php
// 本类由系统自动生成，仅供测试用途
namespace Admin\Controller;

use Think\Controller;

include_once DOC_ROOT . '/Application/Common/service/LoginService.class.php';
class PetManageController extends AdminBaseController {
	protected $newpeturl = "http://www.meipet.com.cn/index.php/Admin/PetManage/newpet";
	protected $petlisturl = "http://www.meipet.com.cn/index.php/Admin/PetManage/petlist";
	
	public function petlist() {
		if (! \LoginService::isLogin ()) {
			$this->error ( "请登录！", $this->loginUrl );
		}
		// 输出模板
		$this->display ();
	}
	
	public function newpet() {
		if (! \LoginService::isLogin ()) {
			$this->error ( "请登录！", $this->loginUrl );
		}
		
		$user = \LoginService::getUserModel ();
		
		$this->assign ( "user", $user );
		$this->assign ( "user_sex", $user ['sex'] );
		// 输出模板
		$this->display ();
	}
	public function create() {
		header ( "Content-Type:text/html; charset=utf-8" );
		if (! \LoginService::isLogin ()) {
			$this->error ( "请登录！", $this->loginUrl );
		}
		$user = \LoginService::getUserModel ();
		
		$Dao = D ( "Pet" );
		if ($Dao->create ()) {
			$Dao->gmt_modified = date ( 'Y-m-d H:i:s', time () );
			$Dao->gmt_create = date ( 'Y-m-d H:i:s', time () );
			$Dao->user_id = $user ['id'];
			$Dao->status = 'open';
			
			$result = $Dao->add ();
			echo $Dao->getLastSql();
			
			if ($result) {
				$this->success ( "创建成功", "$petlisturl" );
			} else {
				$this->error ( "系统错误", "$newpeturl" );
			}
		} else {
			exit ( $Dao->getError () . ' [ <a href="javascript:history.back()">返 回</a> ]' );
		}
	}
	public function changepet() {
		if (! \LoginService::isLogin ()) {
			$this->error ( "请登录！", $this->loginUrl );
		}
		
		$user = \LoginService::getUserModel ();
		
		$this->assign ( "user", $user );
		$this->assign ( "user_sex", $user ['sex'] );
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