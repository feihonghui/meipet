<?php
/**
 * @author    feihonghui
 +------------------------------------------------------------------------------
 */
class HtmlRenderService {
	
	/**
	 * +----------------------------------------------------------
	 * 应用程序初始化
	 * +----------------------------------------------------------
	 *
	 * @access public
	 *         +----------------------------------------------------------
	 * @return void +----------------------------------------------------------
	 */
	static public function errorJson($data) {
		$json ['data'] = $data;
		$json ['success'] = FALSE;
		return $json;
	}
	

	static public function successJson($data) {
		$json ['data'] = $data;
		$json ['success'] = TRUE;
		return $json;
	}
	
}