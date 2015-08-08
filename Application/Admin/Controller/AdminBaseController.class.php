<?php
// 本类由系统自动生成，仅供测试用途
namespace Admin\Controller;

use Think\Controller;

class AdminBaseController extends Controller {
	protected $loginUrl = "http://www.meipet.com.cn/index.php/Home/Log/index";
	protected $domain = "http://www.meipet.com.cn/";
	protected function errorJson($data) {
		$json ['data'] = $data;
		$json ['success'] = FALSE;
		return $json;
	}
	protected function successJson($data) {
		$json ['data'] = $data;
		$json ['success'] = TRUE;
		return $json;
	}
	
	// 验证图片链接
	protected function checkImgUrl($url) {
		if (strpos ( $url, '?' )) {
			$url = explode ( '?', $url );
			$url = $url [0];
		}
		$url = explode ( '.', $url );
		$url = end ( $url ); // 取到最后的值;
		
		$arr = array (
				"jpg",
				"png",
				"gif",
				"bmp" 
		);
		
		echo $url;
		echo "result ";
		echo in_array ( $url, $arr );
		
		if (in_array ( $url, $arr )) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}