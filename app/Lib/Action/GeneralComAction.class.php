<?php
// 通用组件模块
class GeneralComAction extends Action {
    public function mpbar(){
        header("Content-Type:text/html; charset=utf-8");
        $info='这里是网页头部mpbar';
		
		$this->assign( "info", $info );
        //输出模板
        $this->display();
    }
	
	public function mpheader(){
        header("Content-Type:text/html; charset=utf-8");
        $info= '这里是网页头部header';
		$this->assign( "info", $info );
        //输出模板
        $this->display();
    }
	
	public function mpbottom(){
        header("Content-Type:text/html; charset=utf-8");
        $info= '这里是网页底部mpbottom';
		$this->assign( "info", $info );
        //输出模板
        $this->display();
    }
}