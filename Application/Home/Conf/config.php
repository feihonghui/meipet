

<?php
return array(
//线下环境
		'URL_MODEL'			=>	2, // 如果你的环境不支持PATHINFO 请设置为3
		//启用路由功能
		'URL_ROUTER_ON'		=>	true,
		//路由定义
		'URL_ROUTE_RULES'	=> 	array(
				'reg'  =>'Home/Log/index',
				'reg'  =>'Home/reg/index',
				'blog/:year\d/:month\d'	=>	'Blog/archive', //规则路由
				'blog/:id\d'			=>	'Blog/read', //规则路由
				'blog/:cate'			=>	'Blog/category', //规则路由
				'/(\d+)/' 				=>	'Blog/view?id=:1',//正则路由
		),
);
?>



<?php
//线上环境
/*return array(
	
	 'DB_TYPE'   => 'mysql', // 数据库类型
	 'DB_HOST'   => '121.40.181.18', // 服务器地址
	 'DB_NAME'   => 'meipet_online', // 数据库名
	 'DB_USER'   => 'admin_online', // 用户名
	 'DB_PWD'    => 'Hello1234', // 密码
	 'DB_PORT'   => 3306, // 端口
	 'DB_PREFIX' => 'mp_', // 数据库表前缀
);*/
?>