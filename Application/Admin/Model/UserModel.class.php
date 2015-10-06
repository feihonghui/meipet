<?php
namespace Admin\Model;
use Think\Model;


class UserModel extends Model {
	// 自动验证设置
	protected $_validate = array(
			array('name', 'require', '昵称不能为空！', 1),//1为必须验证
			array("name","1,16","长度不能超过16个字符",0,"length"),
			array('city', 'require', '城市不能为空！', 1),//1为必须验证
			array('area', 'require', '区/县不能为空！', 1),//1为必须验证
			array('sex', 'require', '性别不能为空！', 1),//1为必须验证
			array("mail","email","邮箱格式错误！",0),
			array("mobile","^1[3|4|5|8][0-9]\d{4,8}$","手机号格式不正确",0,"regex",1),
	);
	// 自动填充设置
	protected $_auto = array(
			//array('create_time', 'time', self::MODEL_INSERT, 'function'),
	);
}