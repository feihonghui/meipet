(function($){
	$(function(){
		var header = $('#header'),
			userCenter = header.find('.user-center');
		
		$.ajax({
			url: '/log/getUserInfo',
			dataType: 'jsonp'
		}).done(function(data){
			var result = data.result,
				user = data.user;

			if(result && user){
				var name = user.name || user.login_id,
					headUrl = user.face_img || 'http://meipet.com.cn/static/defaulthead.png';
				var isLoginHtml = '<div class="is-login">'+
						'                <div class="user">'+
						'                    <a href="/admin/manage/petlist">'+
						'                        <div class="head-img-box" style="background-image:url('+ headUrl +');"/>'+
						'                        <span class="name">&nbsp;&nbsp;'+name+'</span>'+
						'                    </a>'+
						'                </div>'+
						'                <div class="operation">'+
						'                    <em></em>'+
						'                    <ul>'+
						'                        <li class="no-border">'+
						'                            <a href="/admin/manage/petlist">个人中心</a>'+
						'                        </li>'+
						'						<li><a href="/admin/manage/publish">发布宠物</a></li>	'+
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