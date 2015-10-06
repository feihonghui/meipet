(function($){
	$(function(){
        var imgUploadBox = $('.img-upload-box'),
            imgBox = imgUploadBox.find('.img-box'),
            releasepetForm = $("#releasepet");

        // category
        var categorySelect = releasepetForm.find('select[name="category"]'),
            pinzhongSelect = releasepetForm.find('select[name="pinzhong"]'),
            categoryVal = categorySelect.val(),
            pinzhongVal = pinzhongSelect.val();
        function initPinzhong(){

            function renderPinzhong(category){
                $.ajax({
                    url: '/attribute/getPinzhongList',
                    dataType: 'jsonp',
                    data: {
                        'category':category
                    }
                })
                .done(function(datas) {
                    var data = datas.data,
                        success = datas.success,
                        pzHtml = '',
                        selected = '';

                    if(success){
                        $.each(data, function(index, val) {
                            
                            if(val.order === pinzhongVal){
                                selected = 'selected';
                                pzHtml = pzHtml + '<option value="'+val.order+'" '+selected+' >'+val.pinzhong+'</option>';
                            }else{
                                pzHtml = pzHtml + '<option value="'+val.order+'" >'+val.pinzhong+'</option>';
                            }
                        });
                    }

                    if(selected === ''){
                        pzHtml = '<option value="" selected >请选择品种</option>' + pzHtml;
                    }

                    pinzhongSelect.html(pzHtml);
                });
            }

            if(categoryVal !== ''){
                renderPinzhong(categoryVal);
            }

            categorySelect.on('change', function(event) {
                renderPinzhong(categorySelect.val());
                pinzhongVal = '';
            });
        };

        // city&area
        var citySelect = releasepetForm.find('select[name="city"]'),
            areaSelect = releasepetForm.find('select[name="area"]'),
            cityVal = $.trim(citySelect.val()),
            areaVal = $.trim(areaSelect.val());
        function initCityArea(){
            var selected = '';
            function getSelectHtml(data,val,str,field,success){
                html = '';
                if(success){
                    $.each(data, function(index, valIn) {
                        var fieldValue = valIn[field];
                        if(val === fieldValue){
                            selected = 'selected';
                            html = html + '<option value="'+fieldValue+'"'+selected+' >'+fieldValue+'</option>';
                        }else{
                            html = html + '<option value="'+fieldValue+'" >'+fieldValue+'</option>';
                        }
                    });
                }
                if(selected === ''){
                    html = '<option value="" selected >'+str+'</option>' + html;
                }
                return html;
            }

            $.ajax({
                url: '/attribute/getCityList',
                dataType: 'jsonp'
            })
            .done(function(datas) {
                var data = datas.data,
                    success = datas.success;
                if( cityVal !== '' ){
                    renderArea(cityVal);
                }
                citySelect.html(getSelectHtml(data,cityVal,'请选择城市','city',success));
            });

            var renderArea = function(val){
                $.ajax({
                    url: '/attribute/getAreaList',
                    dataType: 'jsonp',
                    data: {'city': val}
                })
                .done(function(datas) {
                    var data = datas.data,
                        success = datas.success;
                    areaSelect.html(getSelectHtml(data,areaVal,'请选择区域','area',success));
                });
            };

            citySelect.on('change', function(event) {
                renderArea(citySelect.val());
            });
        };

        // initImgUpload
        var imgUrlInput = releasepetForm.find('input[name="img_urls"]'),
            slogansInput = releasepetForm.find('input[name="slogans"]'),
            imgUrlArr = $.trim(imgUrlInput.val()).split('__span__'),
            slogansArr = $.trim(slogansInput.val()).split('__span__');
        function initImgUpload(){
            var uploader = WebUploader.create({
                swf: '/static/gallery/webuploader/uploader.swf',
                server: '/upload.php/Home/Pic/upload_json',
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

            var initHtml = '';
            if(imgUrlArr.length > 0){
                $.each(imgUrlArr, function(index, val) {
                    if(val !== '') {
                        initHtml = initHtml + '<div class="img-item"><a class="delete" href="#"><i class="iconfont">&#xe606;</i></a><img src="' + val + '"><input placeholder="图片描述不能超过50个字符" value="' + slogansArr[index] + '"></div>';
                    }
                });

                imgBox.html(initHtml);
            }

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
        };

        function initForm(){
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
                });

                imgUrlInput.val(imgUrlArr.join('__span__'));
                slogansInput.val(slogansArr.join('__span__'));
                releasepetForm.submit();
            });
        };

        initImgUpload();
        initForm();
        initPinzhong();
        initCityArea();

	});

})(jQuery);