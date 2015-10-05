(function($) {
    function initOptionPos() {
        function resetOptionPos() {
            var winHeight = window.innerHeight,
                beautyBar = $("#beautyBar"),
                beautyFooter = $("#beautyFooter"),
                leftHeight = winHeight - beautyBar.height() - beautyFooter.height(),
                option = $("#indexContent").find('.option'),
                marginTop = (leftHeight - option.height()) / 2;

            if (marginTop < 0) {
                marginTop = 0;
            }
            marginTop = marginTop + beautyBar.height();

            option.css({
                "margin-top": marginTop + 'px'
            });
        }

        resetOptionPos();
        $(window).on('resize', function(event) {
            resetOptionPos();
        });
    };

    function initTab() {
        var indexContent = $('#indexContent'),
            tabTitle = indexContent.find('.tab-title'),
            contentBoxList = indexContent.find('.tab-content .content-box');

        tabTitle.on('click', 'li', function(event) {
            event.preventDefault();
            var that = $(this),
                currentContentBox = contentBoxList.eq(that.index());
            if (!that.hasClass('current')) {
                that.addClass('current').siblings('li').removeClass('current');
                currentContentBox.siblings('.content-box').css({
                    "width": "0px",
                    "display": "none",
                    "opacity": 0,
                    "overflow": "hidden"
                });
                currentContentBox.css({
                    "display": "block"
                }).animate({
                    width: 692,
                    opacity: 1
                }, 200, function() {
                    currentContentBox.css({
                        "overflow": "visible"
                    });
                });
            }
        });
    };

    function initInfo(){
        var userCenter = $('.user-info');
        $.ajax({
            url: '/log/getUserInfo',
            dataType: 'jsonp'
        }).done(function(data){
            var result = data.result,
                user = data.user;
                //console.log(data);
            if(result && user){
                var headUrl = user.face_img || 'http://meipet.com.cn/static/defaulthead.png';
                var isLoginHtml = '<a href=""><div class="head-img" style="background-image:url('+headUrl+');">'+
                        '                    </div></a>'+
                        '                    <ul>'+
                        '                        <li>'+
                        '                            <a href="">个人中心</a>'+
                        '                        </li>'+
                        '                        <li>'+
                        '                            <a href="/admin/manage/publish" target="_blank">发布宠物</a>'+
                        '                        </li>'+
                        '                        <li>'+
                        '                            <a href="" class="checkout">退出登录</a>'+
                        '                        </li>'+
                        '                    </ul>';

                userCenter.html(isLoginHtml);

                userCenter.on('click', '.checkout', function(event) {
                    event.preventDefault();
                    $.ajax({
                        url: '/log/checkout',
                        dataType: 'jsonp'
                    })
                    .done(function(data) {
                        window.location.href = '/';
                    });
                    
                });
            }
        });
    };

    function rendRecom(box,url){
        
        $.ajax({
            url: url,
            dataType: 'jsonp',
            data: {
                page: 1,
                size: 8
            }
        }).done(function(dataIn) {
            var data = dataIn.data;
            if( dataIn.result && data && data.length > 0){
                var html = '';
                $.each(data, function(index, val) {
                    html = html + '<li>'+
                        '                      <a href="/detail?id='+val.id+'">'+
                        '                         <div class="img-box" style="background-image: url('+val.img +');">'+
                        '                              <div class="info ms-yh">'+
                        '                                   <span class="price">价格<br/>&yen;'+val.price/100+'</span>'+
                        '                                   <span class="age">年龄<br/>&le;'+val.month+'</span>'+
                        '                              </div>'+
                        '                              <div class="description">'+
                        '                                   <span class="text">'+ val.subject +'</span>'+
                        '                                   <span class="button">立即领养</span>'+
                        '                              </div>'+
                        '                          </div>'+
                        '                      </a>'+
                        '                     </li>';
                });
                box.html(html);
            }
        });
    };

    $(function() {
        initOptionPos();
        initInfo();
        initTab();
        var rewardRecom = $('.reward-recom');
        rendRecom(rewardRecom,'/list/getPet');
        var freeRecom = $('.free-recom');
        rendRecom(freeRecom,'/list/getPet');
    });
})(jQuery);