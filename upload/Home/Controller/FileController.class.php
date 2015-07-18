<?php

namespace Home\Controller;
use Think\Controller;

include_once DOC_ROOT . '/Application/Common/service/LoginService.class.php';

// 本类由系统自动生成，仅供测试用途
class FileController extends Controller {
	private $loginUrl = "http://www.meipet.com.cn/index.php/Home/Log/index";
	private $domain = "http://www.meipet.com.cn/";
	public function index() {
		if (! \LoginService::isLogin ()) {
			$this->error ( "请登录！", $this->loginUrl );
		}
		header ( "Content-Type:text/html; charset=utf-8" );
		$this->display ();
	}
	public function upload() {
		header ( "Content-Type:text/html; charset=utf-8" );
		if (! \LoginService::isLogin ()) {
			$this->error ( "请登录！", $loginUrl );
		}

		
		$userId = \LoginService::getUserId ();
		$today = date ( 'Ymd', time () );
		$savePath = 'data/file/' . $userId . "/"; // 设置附件上传（子）目录
		
		if (! file_exists ( $savePath )) {
			mkdir ( './data/file/' . $userId );
		}
		

		$config = array(
				'maxSize'    =>    3145728,
				'rootPath'   =>    DOC_ROOT."/",
				'savePath'   =>    $savePath,
				'saveName'   =>    array('uniqid',''),
				//'exts'       =>    array('jpg', 'gif', 'png', 'jpeg'),
				'autoSub'    =>    true,
				'subName'    =>    array('date','Ymd'),
		);
		
		$upload = new \Think\Upload($config); // 实例化上传类
		
		// 上传文件
		$info = $upload->upload ();
		if (! $info) { // 上传错误提示错误信息
			$this->error ( $upload->getError(), "index" );
		} else { // 上传成功
			echo '上传成功！文件地址为：';
			foreach($info as $file){
				echo $this->domain.$file['savepath'].$file['savename'];
			}
			
		}
	}
}