(function($){
	$(function(){
		var mobile = $('#mobile'),
			password = $('#password'),
			doLog = $('#do-log'),
			message = $('#message'),
			loginForm = $('.login-form'),
			fromUrl = decodeURI(Meipet.util.getParamValue('from'));


		if(fromUrl === 'undefined'){
			fromUrl = '/';
		}

		var mobileRex = /^1[3|4|5|8][0-9]\d{4,8}$/;

		doLog.on('click', function(event) {
			event.preventDefault();
			var mobileVal = $.trim(mobile.val()),
				passwordVal = $.trim(password.val());

			if(!mobileRex.test(mobileVal)){
				message.text('请输入正确的手机号');
				return;
			}

			if(passwordVal === ''){
				message.text('请输密码');
				return;
			}

			message.text('登录');

			$.ajax({
				url: '/log/doLog',
				type: 'POST',
				dataType: 'jsonp',
				data: {
					mobile: mobileVal,
					password: passwordVal
				}
			})
			.done(function(data) {
				// console.log(data);
				var result = data.result,
					reason = data.reason;
				if(result){
					window.location.href = fromUrl;
				}else{
					message.text(reason);
				}
			});
		});

		loginForm.on('keypress', function(event) {

			if(event.charCode === 13){
				doLog.trigger('click');
			}

		});
	});
})(jQuery);