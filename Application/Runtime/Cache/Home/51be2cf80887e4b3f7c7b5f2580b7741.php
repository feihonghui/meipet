<?php if (!defined('THINK_PATH')) exit();?>﻿
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
    <title>美优萌宠</title>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
<link rel="stylesheet" href="http://www.meipet.com.cn/static/bootstrap/css/bootstrap.min.css" type="text/css" />
<link rel="stylesheet" href="http://www.meipet.com.cn/static/css/module/form.css" type="text/css" />
</head>
<body>

	<div class="row">
		<div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
			<div class="page-login-form box login">

				<div class="login-description text-center">欢迎来到美优萌宠</div>

				<form action="http://www.meipet.com.cn/index.php/Home/Reg/doReg" method="post" class="form-validate">
					<div class="form-group">
						<div class="group-control">
							<input type="text" name="mobile" id="mobile" value=""
								class="validate-username required" size="25"
								placeholder="手机号" aria-required="true" />
						</div>
					</div>

					<div class="form-group">
						<div class="group-control">
							<input type="text" name="yanzhengma" id="username" value=""
								class="validate-username required" size="6"
								placeholder="短信验证码" aria-required="true"
								style="width: 120px; float: left" />

							<button class="btn" type="button" id='code'
								style="margin-top: 3px; margin-left: 50px;">获取验证码</button>

						</div>
					</div>

					<div class="form-group">
						<div class="group-control">
							<input type="password" name="password" id="password"
								value="" placeholder="密码"
								class="validate-password required" size="25"
								maxlength="99" aria-required="true" />
						</div>
					</div>
					
					<div class="form-group">
						<div class="group-control">
							<input type="password" name="password2" id="password"
								value="" placeholder="密码确认"
								class="validate-password required" size="25"
								maxlength="99" aria-required="true" />
						</div>
					</div>
					
					<div class="form-group">
						<button type="submit"
							class="btn btn-success btn-lg btn-block btn-login">
							注&nbsp;&nbsp;册</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<script src="http://www.meipet.com.cn/static/js/global/jquery.min.js"></script>
	<script src="http://www.meipet.com.cn/static/bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript">
		$("#code").click(
			function() {
				var mobile = $("#mobile").val();
				if (mobile == '') {
					alert('对不起,手机号不能为空');
					return;
				}
				window.open('http://www.meipet.com.cn/index.php/Home/Reg/Verifycode?callback=xxxxxxxx&mobile=' + mobile);
			});
	</script>
</body>
</html>