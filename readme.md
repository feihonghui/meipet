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
验证手机号
http://www.meipet.com.cn/log/checkLoginId?callback=aaa&mobile=13777427165
登陆post接口
http://www.meipet.com.cn/log/doLog?mobile=13777427154&password=1