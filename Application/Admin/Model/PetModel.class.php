<?php
namespace Admin\Model;
use Think\Model;


class PetModel extends Model {
	// 自动验证设置
	protected $_validate = array(
			array('subject', 'require', '标题不能为空！', 1),//1为必须验证
			array("subject","1,5","标题不能超过32个字符",0,"length"),
			array('category', 'require', '类目不能为空！', 1),//1为必须验证
			array('pinzhong', 'require', '品种不能为空！', 1),//1为必须验证
			array('city', 'require', '城市不能为空！', 1),//1为必须验证
			array('area', 'require', '区/县不能为空！', 1),//1为必须验证
			array('sex', 'require', '性别不能为空！', 1),//1为必须验证
	);
	// 自动填充设置
	protected $_auto = array(
			//array('create_time', 'time', self::MODEL_INSERT, 'function'),
	);
}