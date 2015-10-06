(function($){
	$(function(){
        var imgUploadBox = $('.img-upload-box'),
            imgBox = imgUploadBox.find('.img-box'),
            setInfoForm = $("#set-info");


        // city&area
        var citySelect = setInfoForm.find('select[name="city"]'),
            areaSelect = setInfoForm.find('select[name="area"]'),
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
        var imgUrlInput = setInfoForm.find('input[name="face_img"]'),
            imgBox = $('#img-box');
        function initImgUpload(){
            var uploader = WebUploader.create({
                swf: '/static/gallery/webuploader/uploader.swf',
                server: '/upload.php/Home/Pic/upload_json',
                pick: '#add-img',
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
                imgBox.html('<div class="big-img" style=\'background-image:url('+response.fileUrl+');\'>'+
                            '</div>'+
                            '<div class="small-img"style=\'background-image:url('+response.fileUrl+');\'>'+
                            '</div>');

                imgUrlInput.val(response.fileUrl);
            });
            uploader.on( 'uploadError', function( file ) {
                alert('上传出错，请重新上传！');
            });
        };

        function initForm(){
            setInfoForm.Validform({
                tiptype: 2
            });

            setInfoForm.on('click','input.btn-release',function(event){
                event.preventDefault();
                setInfoForm.submit();
            });
        };

        initImgUpload();
        initForm();
        initCityArea();
	});

})(jQuery);