<?php
namespace Admin\Model;
use Think\Model;


class StoreModel extends Model {
	// 自动验证设置
	protected $_validate = array(
			array('name', 'require', '名称不能为空！', 1),//1为必须验证
			array("name","1,16","名称不能超过16个字符",0,"length"),
			array('city', 'require', '城市不能为空！', 1),//1为必须验证
			array('area', 'require', '地区不能为空！', 1),//1为必须验证
			array('level', 'require', '店铺资质不能为空！', 1),//1为必须验证
	);
	// 自动填充设置
	protected $_auto = array(
			//array('create_time', 'time', self::MODEL_INSERT, 'function'),
	);
}
