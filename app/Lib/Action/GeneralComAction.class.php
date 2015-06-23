<?php
// 通用组件模块
class GeneralComAction extends Action {
    public function mpbar(){
        header("Content-Type:text/html; charset=utf-8");
        echo '这里是网页头部mpbar';
    }
	
	public function header(){
        header("Content-Type:text/html; charset=utf-8");
        echo '这里是网页头部header';
    }
	
	public function mpbottom(){
        header("Content-Type:text/html; charset=utf-8");
        echo '这里是网页底部mpbottom';
    }
}