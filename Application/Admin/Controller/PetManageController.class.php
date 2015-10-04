<?php
// 本类由系统自动生成，仅供测试用途
namespace Admin\Controller;

use Think\Controller;

include_once DOC_ROOT . '/Application/Common/service/LoginService.class.php';
class PetManageController extends AdminBaseController {
	protected $newpeturl = "http://www.meipet.com.cn/index.php/Admin/PetManage/newpet";
	protected $petlisturl = "http://www.meipet.com.cn/index.php/Admin/PetManage/petlist";
	
	protected $span='__span__';
	
	public function petlist() {
		if (! \LoginService::isLogin ()) {
			$this->error ( "请登录！", $this->loginUrl );
		}
		
		$user = \LoginService::getUserModel ();
		
		$Dao = M ( "pet" );
		$condition ['user_id'] = $user ['id'];
		
		$petList = $Dao->where ( $condition )->order ( 'gmt_modified DESC' )->select ();
		$this->assign ( "petList", $petList );
		// 输出模板
		$this->display ();
	}
	public function publish() {
		if (! \LoginService::isLogin ()) {
			$this->error ( "请登录！", $this->loginUrl );
		}
		// 输出模板
		$this->display ();
	}
	public function create() {
		if (! \LoginService::isLogin ()) {
			$this->error ( "请登录！", $this->loginUrl );
		}
		$user = \LoginService::getUserModel ();
		header ( "Content-Type:text/html; charset=utf-8" );
		
		$img_urls = $_POST ["img_urls"];
		$slogans = $_POST ["slogans"];
		
		$imgArray = split($this->span,$img_urls);
		$imgArrayCount= count($imgArray);
		$sloganArray = split($this->span,$slogans);
		$sloganArrayCount=count($sloganArray);
		if($imgArrayCount<1||$sloganArrayCount<1){
			$this->error ( "请上传图片", $this->loginUrl );
		}

		$Dao = D ( "Pet" );
		if ($Dao->create ()) {
			$Dao->gmt_modified = date ( 'Y-m-d H:i:s', time () );
			$Dao->gmt_create = date ( 'Y-m-d H:i:s', time () );
			$Dao->user_id = $user ['id'];
			$Dao->status = 'open';
			$Dao->img=$imgArray[0];
			$Dao->price=100 * $Dao->price;
			$result = $Dao->add ();
			
			if (!$result) {
				$this->error ( "系统错误", "$newpeturl" );
			}
			
			//创建图片
			$petImgDao = M ( "pet_img" );

			for ($i = 0; $i < $imgArrayCount; $i++) { 
				// 构建写入的数据数组
				$data ["gmt_create"] = date ( 'Y-m-d H:i:s', time () );
				$data ["gmt_modified"] = date ( 'Y-m-d H:i:s', time () );
				$data ["pet_id"] = $result;
				$data ["img_url"] = $imgArray[$i];
				$data ["dec"] = $sloganArray[$i];
				// 写入数据
				$lastInsId = $petImgDao->add ( $data );
			}  
			
			$this->success ( "创建成功", "$petlisturl" );
			
		} else {
			exit ( $Dao->getError () . ' [ <a href="javascript:history.back()">返 回</a> ]' );
		}
		
	}
	public function edit() {
		if (! \LoginService::isLogin ()) {
			$this->error ( "请登录！", $this->loginUrl );
		}
		
		$user = \LoginService::getUserModel ();
		
		$petid = $_GET ["petid"];
		if ($petid == null || $petid == "") {
			$this->error ( "参数错误", "$petlisturl" );
		}
		
		$Dao = M ( "pet" );
		$condition ['id'] = $petid;
		$pet = $Dao->where ( $condition )->find ();
		$this->assign ( "pet", $pet );
		
		$petImgDao = M ( "pet_img" );
		$condition2 ['pet_id'] = $petid;
		$imgLit=$petImgDao->where ( $condition2 )->select ();
		$img_urls=$this->getImgUrls($imgLit);
		$slogans=$this->getSlogans($imgLit);
		$this->assign ( "img_urls", $img_urls );
		$this->assign ( "slogans", $slogans );
		// 输出模板
		$this->display ();
	}
	
	private function getImgUrls($imgLit) {
		$result="";
		for ($i= 0;$i< count($imgLit); $i++){
			if($i!=0){
				$result=$result.$this->span;
			}
			$img= $imgLit[$i];
			$result=$result.$img["img_url"];
		}
		return $result;
	}
	
	private function getSlogans($imgLit) {
		$result="";
		for ($i= 0;$i< count($imgLit); $i++){
			if($i!=0){
				$result=$result.$this->span;
			}
			$img= $imgLit[$i];
			$result=$result.$img["dec"];
		}
		return $result;
	}
	
	public function update() {
		header ( "Content-Type:text/html; charset=utf-8" );
		if (! \LoginService::isLogin ()) {
			$this->error ( "请登录！", $this->loginUrl );
		}
		\LoginService::getUserModel ();
		
		$Dao = D ( "Pet" );
		if ($Dao->create ()) {
			$Dao->gmt_modified = date ( 'Y-m-d H:i:s', time () );
			
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
	public function uploadPetImg() {
		header ( "Content-Type:text/html; charset=utf-8" );
		if (! \LoginService::isLogin ()) {
			return $this->ajaxReturn ( $this->errorJson ( "not login" ), 'jsonp' );
		}
		
		$user = \LoginService::getUserModel ();
		
		$img_url = $_GET ["img_url"];
		$pet_id = $_GET ["pet_id"];
		$dec = $_GET ["dec"];
		
		if (empty ( $img_url ) || empty ( $pet_id )) {
			return $this->ajaxReturn ( $this->errorJson ( "param null" ), 'jsonp' );
		}
		
		if ($this->checkImgUrl($img_url)){
			return $this->ajaxReturn ( $this->errorJson ( "img_url error" ), 'jsonp' );
		}
		
		$PetDao = M ( "Pet" );
		$condition ['id'] = $pet_id;
		$pet = $PetDao->where ( $condition )->find ();
		if (empty ( $pet ) || $pet ['user_id'] != $user ['id']) {
			return $this->ajaxReturn ( $this->errorJson ( "pet error" ), 'jsonp' );
		}
		
		$Dao = M ( "PetImg" );
		
		$petImg ['img_url'] = $img_url;
		$petImg ['pet_id'] = $pet_id;
		$petImg ['dec'] = $dec;
		$petImg ['gmt_create'] = date ( 'Y-m-d H:i:s', time () );
		$petImg ['gmt_modified'] = date ( 'Y-m-d H:i:s', time () );
		
		if ($lastInsId = $Dao -> add ( $petImg )) {
			//echo $Dao->getLastSql();
			return $this->ajaxReturn ( $this->successJson ( "ok" ), 'jsonp' );
		} else {
			//echo $Dao->getLastSql();
			return $this->ajaxReturn ( $this->errorJson ( $Dao->getError () ), 'jsonp' );
		}
	}
}