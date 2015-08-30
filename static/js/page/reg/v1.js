(function($){

	$(function(){
		var mobile = $('#mobile'),
			identifyCode = $('#identify-code'),
			getIdentifyCode = $('#get-identify-code'),
			password = $('#password'),
			password2 = $('#password2'),
			doReg = $('#do-reg'),
			message = $('#message'),
			loginForm = $('.login-form');

		var mobileRex = /^1[3|4|5|8][0-9]\d{4,8}$/,
			hasRegisterFlag = false;

		var mobileVal,
			identifyCodeVal,
			passwordVal,
			password2Val;

		function getVals(){
			mobileVal = $.trim(mobile.val());
			identifyCodeVal = $.trim(identifyCode.val());
			passwordVal = $.trim(password.val());
			password2Val = $.trim(password2.val());
		}

		function setOkMessae(){
			message.text('注册');
		}

		getIdentifyCode.on('click', function(event) {
			event.preventDefault();
			var that = $(this);
			getVals();

			if(!mobileRex.test(mobileVal)){
				message.text('请输入正确的手机号！');	
			} else {

				setOkMessae();

				$.ajax({
					url: '/reg/checkLoginId',
					dataType: 'jsonp',
					data: {mobile: mobileVal}
				})
				.done(function(data) {

					if(data.result){

						setOkMessae();

						$.ajax({
							url: '/reg/Verifycode',
							dataType: 'jsonp',
							data: {mobile: mobileVal}
						})
						.done(function(data) {
							var reason = data.reason,
								result = data.result;
							if(result){
								that.addClass('forbidden');
								that.text('验证码已发送');
								that.off('click');

								if(reason === "hasSended"){
									message.text('验证码30分钟内有效，可直接使用！');
								}

							}else{

							}
						});

					}else{
						hasRegisterFlag = true;
						message.text('该手机号已经被注册！');
					}

				});
			}
		});

		doReg.on('click', function(event) {
			event.preventDefault();
			getVals();
			
			if(hasRegisterFlag){
				return;
			}

			if(!mobileRex.test(mobileVal)){
				message.text('请输入正确的手机号！');
				return;
			}

			if(identifyCodeVal === ''){
				message.text('请输入短信验证码！');
				return;
			}

			if(passwordVal.length < 6){
				message.text('密码长度不能小于六位！');
				return;
			}

			if(passwordVal !== password2Val){
				message.text('两次输入的密码不一致！');
				return;
			}

			$.ajax({
				url: '/reg/doReg',
				type: 'POST',
				dataType: 'jsonp',
				data: {
					mobile: mobileVal,
					yanzhengma: identifyCodeVal,
					password: passwordVal,
					password2: password2Val
				}
			})
			.done(function(data) {
				var result = data.result,
					reason = data.reason;

				if(result){
					var dialog = $.dialog({
							minWidth:1000,
							html: '<div style="height:45px;width:270px;text-align:center;line-height:45px;background:rgba(0,0,0,0.77);color:#fff;">注册成功，正在跳转到登录页面！</div>',
			              	timers:[
				                {
									callback: function(){
										this.hide();
										window.location.href = "/log";
									},
									time: 1500
				                }
				            ]
				       	});
					dialog.show();

				}else{
					message.text(reason);
				}
			});
		});

		loginForm.on('keypress', function(event) {

			if(event.charCode === 13){
				doReg.trigger('click');
			}

		});
	});

})(jQuery);