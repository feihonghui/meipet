
通用接口:

	获取用户信息:
	http://www.meipet.com.cn/log/getUserInfo

	退出登陆:
	http://www.meipet.com.cn/log/checkout

	注册相关：

	注册时获取验证码：
	http://www.meipet.com.cn/reg/Verifycode?callback=xxxxxxxx&mobile=13777427154

	验证手机号码：（已注册和号码错误）
	http://www.meipet.com.cn/reg/checkLoginId?callback=aaa&mobile=13734632465

	注册接口
	http://www.meipet.com.cn/reg/doReg?
	$mobile = $_POST ["mobile"];
	$password = $_POST ["password"];
	$password2 = $_POST ["password2"];
	$yanzhengma = $_POST ["yanzhengma"];


登陆相关：

	验证手机号：
	http://www.meipet.com.cn/log/checkLoginId?callback=aaa&mobile=13777427165

	登陆post接口：
	http://www.meipet.com.cn/log/doLog?
	$mobile = $_POST ["mobile"];
	$password = $_POST ["password"];

	找回密码：
	http://www.meipet.com.cn/forget/getPassword
	$mobile = $_POST ["mobile"];
	$password = $_POST ["password"];
	$password2 = $_POST ["password2"];
	$yanzhengma = $_POST ["yanzhengma"];

宠物列表接口：

	http://www.meipet.com.cn/list/getPet?category=dog&area=%E6%BB%A8%E6%B1%9F%E5%8C%BA&city=%E6%9D%AD%E5%B7%9E&page=2&size=1
	
	我发布的宠物列表接口：
	http://www.meipet.com.cn/admin/manage/myPetList
	
	删除宠物接口：
	http://www.meipet.com.cn/admin/manage/delPet?petid=1
	
	
个人商店宠物接口  	
http://www.meipet.com.cn/store/getPet?userId=2&callback=aaa&adoptId=&page=&size


获取城市列表
http://www.meipet.com.cn/attribute/getCityList

获取区域列表
http://www.meipet.com.cn/attribute/getAreaList?city=%E6%9D%AD%E5%B7%9E

获取种类品种
http://www.meipet.com.cn/attribute/getPinzhongList?category=cat

发布宠物页面
http://www.meipet.com.cn/admin/PetManage/newpet

立即领养接口
http://www.meipet.com.cn/detail/adopt?petid=3620
