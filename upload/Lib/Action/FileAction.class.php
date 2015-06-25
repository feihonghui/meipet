<?php
require_once DOC_ROOT . '\Extend\Library\ORG\Net\UploadFile.class.php';
// 本类由系统自动生成，仅供测试用途
class FileAction extends Action {
    public function index(){
        header("Content-Type:text/html; charset=utf-8");
        $this->display();
    }
    
    public function upload(){
    
    $upload = new UploadFile();// 实例化上传类
    $upload->maxSize   =     3145728 ;// 设置附件上传大小
    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
    $upload->rootPath  =     DOC_ROOT . '/data/'; // 设置附件上传根目录
    $upload->savePath  =     'file'; // 设置附件上传（子）目录
    // 上传文件 
    $info   =   $upload->upload();
    if(!$info) {// 上传错误提示错误信息
        $this->error($upload->getErrorMsg());
    }else{// 上传成功
        $this->success('上传成功！');
    }
}
}