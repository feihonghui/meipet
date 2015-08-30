<?php if (!defined('THINK_PATH')) exit();?><html lang="zh-CN">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <title>美优萌宠</title>
    <link rel="shortcut icon" href="http://www.meipet.com.cn/static/img/favicon.png" />
    <!-- global-->
    <link rel="stylesheet" type="text/css" href="http://www.meipet.com.cn/static/css/global/reset.css">
    <link rel="stylesheet" type="text/css" href="http://www.meipet.com.cn/static/css/global/layout.css">
    <!-- module-->
    <link rel="stylesheet" type="text/css" href="http://www.meipet.com.cn/static/css/module/header.css">
    <link rel="stylesheet" type="text/css" href="http://www.meipet.com.cn/static/css/module/footer.css">
    <!-- page-->
    <link rel="stylesheet" type="text/css" href="http://www.meipet.com.cn/static/css/page/detail/main-content.css">
</head>

<body>
    <div id="header">
        <div class="layout-990">
            <h1><a href="#" title="美优萌宠"><img src="http://www.meipet.com.cn/static/img/logo.png"></a></h1>
            <ul class="nav ms-yh">
                <li><a href="/">首页</a></li>
                <li class="current"><a href="/list">有偿领养</a></li>
                <li><a href="/list">无偿领养</a></li>
            </ul>
            <div class="user-center">
                <a class="no-login" href="#" target="_self">登录</a>
                <!-- <div class="is-login">
                <div class="user">
                    <a href="#">
                        <img onerror="this.src='http://i04.c.aliimg.com/cms/upload/2014/821/102/2201128_1754507855.png'" src="http://img.taobaocdn.com/i3/T1YeSiXk8eXXb1upjX.jpg"/>
                        <span class="name">&nbsp;&nbsp;水牛儿27</span>
                    </a>
                </div>
                <div class="operation">
                    <em></em>
                    <ul>
                        <li class="no-border">
                            <a href="/tuan/myInfo.htm">个人中心</a>
                        </li>
                        <li>
                            <a href="#" target="_self" >退出登录</a>
                        </li>
                    </ul>
                </div>
            </div> -->
            </div>
        </div>
    </div>
    <div id="content">
        <div class="layout-990">
            <div class="main-content">
                <h3 class="ms-yh">
                    <span><?php echo ($pet["subject"]); ?></span>
                    <span class="bdsharebuttonbox">
                        <a href="#" class="bds_more" data-cmd="more"></a>
                        <a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a>
                        <a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a>
                        <a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a>
                    </span>
                </h3>
                <p class="description"><?php echo ($pet["description"]); ?></p>
                <p>
                    <img src="<?php echo ($pet["img"]); ?>">
                </p>
                <?php if(is_array($imgList)): $i = 0; $__LIST__ = $imgList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><p>
		                <?php if(!empty($vo["dec"])): ?><span><?php echo ($vo["dec"]); ?></span><?php endif; ?>
	                    <img src="<?php echo ($vo["img_url"]); ?>">
	                </p><?php endforeach; endif; else: echo "" ;endif; ?>
               

            </div>

            <div class="main-info">
                <h3 class="ms-yh">萌宠详细信息</h3>
                <ul>
                    <li>
                        <span class="title">萌宠种类:</span>
                        <?php if(($pet["category"] == 'cat') ): ?><span class="info">喵星人</span>
						<?php elseif(($pet["category"] == 'dog')): ?>
							<span class="info">汪星人</span><?php endif; ?>
                    </li>
                    <li>
                        <span class="title">萌宠品种:</span>
                        <span class="info"><?php echo ($pet["pinzhong"]); ?></span>
                    </li>
                    <li>
                        <span class="title">萌宠性别:</span>
                        <?php if(($pet["sex"] == 'M') ): ?><span class="info">公</span>
						<?php elseif(($pet["sex"] == 'F')): ?>
							<span class="info">母</span><?php endif; ?>
                    </li>
                    <li>
                        <span class="title">萌宠颜色:</span>
                        <span class="info"><?php echo ($pet["color"]); ?></span>
                    </li>
                    <li>
                        <span class="title">萌宠生日:</span>
                        <span class="info"><?php echo ($birthday); ?></span>
                    </li>
                    <li>
                        <span class="title">健康状态:</span>
                        <span class="info">良好</span>
                    </li>

                    <li>
                        <span class="title">参考价格:</span>
                        <span class="info">&yen;<?php echo ($price); ?></span>
                    </li>

                    <li>
                        <span class="title">所在区域:</span>
                        <span class="info"><?php echo ($pet["area"]); ?> <?php echo ($pet["address"]); ?></span>
                    </li>
                </ul>
                <span class="get-now" data-name="<?php echo ($user["name"]); ?>" data-phone="<?php echo ($user["mobile"]); ?>">立即领养</span>
            </div>
        </div>
    </div>
    <div id="footer" class="ms-yh">
        <div class="layout-990">
            <span class="copyright">
            Copyright&nbsp;©&nbsp;<a href="#" target="_self">杭州美呦科技有限公司</a>&nbsp;&nbsp;2015-2018&nbsp;&nbsp;版权所有
        </span>
            <br>
            <a href="#">关于美优</a>&nbsp;|&nbsp;<a href="#">团队介绍</a>&nbsp;|&nbsp;<a href="#">加入我们</a>
        </div>
    </div>
</body>
<!-- global-->
<script type="text/javascript" src="http://www.meipet.com.cn/static/jquery/jquery.min.js"></script>
<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":["weixin","qzone","douban","tqq","tsina","sqq","kaixin001","tqf","tieba","diandian","huaban","mail"],"bdPic":"","bdStyle":"0","bdSize":"16"},"share":{},"selectShare":{"bdContainerClass":null,"bdSelectMiniList":["weixin","qzone","tsina"]}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
<!-- module-->
<!-- page-->

</html>