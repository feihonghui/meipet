<?php
// 本类由系统自动生成，仅供测试用途
namespace Admin\Controller;

use Think\Controller;

include_once DOC_ROOT . '/Application/Common/service/LoginService.class.php';
class ShopController extends AdminBaseController {
	protected $shopOpen = "http://www.meipet.com.cn/admin/shop/open";
	protected $shopSet = "http://www.meipet.com.cn/admin/shop/set";
	public function open() {
		if (! \LoginService::isLogin ()) {
			$this->error ( "请登录！", $this->loginUrl );
		}
		
		$user = \LoginService::getUserModel ();
		if('Y'==$user['shop']){
			//已经开通店铺
			header("Location: /admin/shop/set");
			return;
		}

		$this->assign ( "user", $user );
		// 输出模板
		$this->display ();
	}
	
	public function create() {
		if (! \LoginService::isLogin ()) {
			$this->error ( "请登录！", $this->loginUrl );
		}
		$user = \LoginService::getUserModel ();
		if('Y'==$user['shop']){
			//已经开通店铺
			header("Location: /admin/shop/set");
			return;
		}
		
		$Dao = D ( "Store" );
		if ($Dao->create ()) {
			$Dao->gmt_modified = date ( 'Y-m-d H:i:s', time () );
			$Dao->gmt_create = date ( 'Y-m-d H:i:s', time () );
			$Dao->user_id = $user ['id'];
			$result = $Dao->add ();
			if (!$result) {
				$this->error ( "系统错误", "$shopOpen" );
			}
		}
		
		//创建成功，修改信息
		$user['shop']='Y';
		$user['gmt_modified'] = date ( 'Y-m-d H:i:s', time ());
		$userDao = D ( "user" );
		$userDao->where("id=".$user["id"])->save ($user);
		$this->success ( "创建成功", $shopSet );
	}
	
	public function set() {
		if (! \LoginService::isLogin ()) {
			$this->error ( "请登录！", $this->loginUrl );
		}
	
		$user = \LoginService::getUserModel ();
		if('Y'!=$user['shop']){
			//未开通店铺
			header("Location: /admin/shop/open");
			return;
		}

		$userId=$user["id"];
		$Dao = M ( "store" );
		$store=$Dao->where("user_id=".$userId)->find();
	
		$this->assign ( "store", $store );
		// 输出模板
		$this->display ();
	}
	
	
	public function update() {
		if (! \LoginService::isLogin ()) {
			$this->error ( "请登录！", $this->loginUrl );
		}
	
		$user = \LoginService::getUserModel ();
		if('Y'!=$user['shop']){
			//未开通店铺
			header("Location: /admin/shop/open");
			return;
		}
		
		
		$Dao = D ( "Store" );
		if ($Dao->create ()) {
			$Dao->gmt_modified = date ( 'Y-m-d H:i:s', time () );
			
			if('Y'!=$Dao->adopt){$Dao->adopt='N';}
			if('Y'!=$Dao->cosmet){$Dao->cosmet='N';}
			if('Y'!=$Dao->wash){$Dao->wash='N';}
			if('Y'!=$Dao->medical){$Dao->medical='N';}
			if('Y'!=$Dao->jiyang){$Dao->jiyang='N';}
			if('Y'!=$Dao->baihuo){$Dao->baihuo='N';}
			
			$result = $Dao->save ();
			if (!$result) {
				$this->error ( "系统错误", "$shopOpen" );
			}
		}else{
			$this->error ( "系统错误", "$shopOpen" );
		}
		// 输出模板
		$this->success ( "保存成功", $shopSet );
	}
	
}