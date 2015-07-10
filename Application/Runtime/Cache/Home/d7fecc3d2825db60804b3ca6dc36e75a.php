<?php if (!defined('THINK_PATH')) exit();?><html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <title>美优萌宠——登陆</title>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <link rel="shortcut icon" href="http://www.meipet.com.cn/static/img/favicon.png"/>
    <link rel="stylesheet" href="http://www.meipet.com.cn/static/bootstrap/css/bootstrap.min.css" type="text/css" />
    <link rel="stylesheet" href="http://www.meipet.com.cn/static/css/module/form.css" type="text/css" />
</head>
<body>
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
            <div class="page-login-form box login">

                <div class="login-description text-center">
                    欢迎来到美优萌宠
                </div>

                <form action="http://www.meipet.com.cn/index.php/Home/Log/doLog" method="post"class="form-validate">



                    <div class="form-group">
                        <div class="group-control">
                            <input type="text" name="mobile" id="username" value=""
                                class="validate-username required" size="25"
                                placeholder="手机号" required aria-required="true" />
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="group-control">
                            <input type="password" name="password" id="password"
                                value="" placeholder="密码"
                                class="validate-password required" size="25"
                                maxlength="99" required aria-required="true" />
                        </div>
                    </div>
                    <div class="form-group">
                        <a href="http://www.meipet.com.cn/index.php/Home/Reg/forget"> 忘记密码</a>
                    </div>
                    <div class="form-group">
                        <button type="submit"
                            class="btn btn-success btn-lg btn-block btn-login">
                            登    录</button>
                    </div>
                </form>
            </div>

            <div class="form-links">
                <ul>
                  <li>现在还没有账号<a href="http://www.meipet.com.cn/index.php/Home/Reg/index"> 立即注册</a></li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>