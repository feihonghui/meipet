(function($){
	$(function(){
		var header = $('#header'),
			userCenter = header.find('.user-center');
		
		$.ajax({
			url: '/log/getUserInfo',
			dataType: 'jsonp'
		}).done(function(data){
			//console.log(data);
			var result = data.result,
				user = data.user;

			if(result && user){
				var isLoginHtml = '<div class="is-login">'+
						'                <div class="user">'+
						'                    <a href="/tuan/myInfo.htm">'+
						'                        <img onerror="this.src=\'http://i04.c.aliimg.com/cms/upload/2014/821/102/2201128_1754507855.png\'" src="http://img.taobaocdn.com/i3/T1YeSiXk8eXXb1upjX.jpg"/>'+
						'                        <span class="name">&nbsp;&nbsp;水牛儿27</span>'+
						'                    </a>'+
						'                </div>'+
						'                <div class="operation">'+
						'                    <em></em>'+
						'                    <ul>'+
						'                        <li class="no-border">'+
						'                            <a href="/tuan/myInfo.htm">个人中心</a>'+
						'                        </li>'+
						'                        <li>'+
						'                            <a href="" class="checkout" target="_self" >退出登录</a>'+
						'                        </li>'+
						'                    </ul>'+
						'                </div>'+
						'            </div>';

				userCenter.html(isLoginHtml);

				userCenter.on('click', '.checkout', function(event) {
					event.preventDefault();
					$.ajax({
						url: '/log/checkout',
						dataType: 'jsonp'
					})
					.done(function(data) {
						// console.log(data);
						window.location.href = '/';
					});
					
				});
			}else{
				userCenter.on('click', '.no-login', function(event) {
					event.preventDefault();
					var href = window.location.href;
					window.location.href = '/log?from=' + href;
				});
			}
		});
	});
})(jQuery);