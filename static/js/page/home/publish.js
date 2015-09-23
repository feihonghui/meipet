(function($){
	$(function(){
	    var hostName = window.location.hostname;
	    var uploader = WebUploader.create({
            swf: 'http://' + hostName + '/static/gallery/webuploader/uploader.swf',
            server: 'http://' + hostName + '/upload.php/Home/Pic/upload_json',
            pick: '.add-img',
            resize: false,
            auto: true,
            duplicate: true,
            accept: {
                title: 'Images',
                extensions: 'gif,jpg,jpeg,bmp,png',
                mimeTypes: 'image/*'
            }
        });
        uploader.on( 'uploadSuccess', function( file , response ) {
            imgBox.append('<div class="img-item"><a class="delete" href="#"><i class="iconfont">&#xe606;</i></a><img src="'+response.fileUrl+'"><input placeholder="图片描述不能超过50个字符"></div>');
        });
        uploader.on( 'uploadError', function( file ) {
            alert('上传出错，请重新上传！');
        });

        var imgUploadBox = $('.img-upload-box'),
        	imgBox = imgUploadBox.find('.img-box'),
            releasepetForm = $("#releasepet"),
            imgUrlInput = releasepetForm.find('input[name="img_urls"]'),
            slogansInput = releasepetForm.find('input[name="slogans"]'),
            imgUrlArr = $.trim(imgUrlInput.val()).split('__span__'),
            slogansArr = $.trim(slogansInput.val()).split('__span__'),
            initHtml = '';

        $.each(imgUrlArr, function(index, val) {
             initHtml = initHtml + '<div class="img-item"><a class="delete" href="#"><i class="iconfont">&#xe606;</i></a><img src="' + val + '"><input placeholder="图片描述不能超过50个字符" value="' + slogansArr[index] + '"></div>';
        });
        imgBox.html(initHtml);

        releasepetForm.Validform({
            tiptype: 2
        });

        releasepetForm.on('click','input.btn-release',function(event){
            event.preventDefault();
            var imgUrlArr = [],
                slogansArr = [];
            imgBox.find('.img-item').each(function(index, el) {
                var that = $(el);
                imgUrlArr.push(that.find('img').attr('src'));
                slogansArr.push($.trim(that.find('input').val()));

                imgUrlInput.val(imgUrlArr.join('__span__'));
                slogansInput.val(slogansArr.join('__span__'));
            });
            releasepetForm.submit();
        });

        imgBox.on('click','.img-item a.delete',function(event){
            event.preventDefault();
            $(this).parent('.img-item').remove();
        });

        imgBox.on('keyup', 'input', function(event) {
            var that = $(this),
                val = $.trim(that.val());
            if(val.length >= 50){
                event.preventDefault();
                that.val(val.substr(0,50));
            }
        });

	});

})(jQuery);