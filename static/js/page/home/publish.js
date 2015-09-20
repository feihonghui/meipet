(function($){

	$(function(){
		$("#releasepet").Validform({
	        tiptype: 2
	    });
	    var hostName = window.location.hostname;
	    var uploader = WebUploader.create({
            swf: 'http://' + hostName + '/static/gallery/webuploader/uploader.swf',
            server: 'http://' + hostName + '/upload.php/Home/Pic/upload_json',
            pick: '.add-img',
            resize: false,
            auto: true

        });

        var imgUploadBox = $('.img-upload-box'),
        	imgBox = imgUploadBox.find('.img-box');

        uploader.on( 'uploadSuccess', function( file , response ) {
            imgBox.append('<div class="img-item"><img src="'+response.fileUrl+'"><input placeholder="图片描述不能超过30个字符"></div>')
            //response.fileUrl;
        });

        uploader.on( 'uploadError', function( file ) {

        });
	});

})(jQuery);