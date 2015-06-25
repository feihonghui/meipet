<?php
require_once DOC_ROOT . '\app\Lib\service\LoginService.class.php';
// 本类由系统自动生成，仅供测试用途
class IndexAction extends Action {
    public function index(){
        $content='这里是网站主题部分';
		$this->assign( "content", $content );
		$this->assign( "loginId", LoginService::getLoginId() );
        //输出模板
        $this->display();
	}
}