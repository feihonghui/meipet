<?php
require_once DOC_ROOT . '\Extend\Library\ORG\Net\UploadFile.class.php';
require_once DOC_ROOT . '\Extend\Library\ORG\Util\Image.class.php';

require_once DOC_ROOT . '\app\Lib\service\LoginService.class.php';

// 本类由系统自动生成，仅供测试用途
class PicAction extends Action {
	private $loginUrl = "http://www.meipet.com.cn/index.php/Log/index";
	private $fileUrl = "http://www.meipet.com.cn/data/pic/";
	public function index() {
		if (! LoginService::isLogin ()) {
			$this->error ( "请登录！", $this->loginUrl );
		}
		header ( "Content-Type:text/html; charset=utf-8" );
		$this->display ();
	}
	public function upload() {
		header ( "Content-Type:text/html; charset=utf-8" );
		if (! LoginService::isLogin ()) {
			$this->error ( "请登录！", $loginUrl );
		}
		
		$upload = new UploadFile (); // 实例化上传类
		$upload->maxSize = 3145728; // 设置附件上传大小
		$upload->allowExts = array (
				'jpg',
				'gif',
				'png',
				'jpeg' 
		); // 设置附件上传类型
		$userId = LoginService::getUserId ();
		$today = date ( 'Ymd', time () );
		$upload->savePath = './data/pic/' . $userId . "/" . $today . "/"; // 设置附件上传（子）目录
		
		if (! file_exists ( $upload->savePath )) {
			mkdir ( './data/pic/' . $userId );
		}
		
		$fileNames = "";
		$i = 0;
		
		$file_paths = array ();
		foreach ( $_FILES as $file ) {
			if ($i != 0) {
				$fileNames = $fileNames . ",";
			}
			$baseurl = $this->fileUrl . $userId . "/" . $today . '/';
			$fileNames = $fileNames . $baseurl . $file ['name'];
			
			$file_paths [i] = $upload->savePath . $file ['name'];
			$i ++;
		}
		
		// 上传文件
		$info = $upload->upload ();
		if (! $info) { // 上传错误提示错误信息
			$this->error ( $upload->getErrorMsg (), "index" );
		} else { // 上传成功
			echo '上传成功！文件地址为：';
			echo $fileNames;
		}
		
		// 图像处理，将图像分级
		$image = new Image ();
		$sizes = array (
				150,
				120,
				100,
				50,
				20 
		);
		foreach ( $file_paths as $file_path ) {
			
			$info = $image->getImageInfo ( $file_path );
			
			$width = $info ['width']; // 返回图片的宽度
			$height = $info ['heigth']; // 返回图片的高度
			
			foreach ( $sizes as $size ) {
				if ($width < $size && $height < $size) {
					continue;
				}
				
				$image->thumb ( $file_path, $file_path . "." . $size . ".jpg", $type = '' );
			}
		}
	}
}