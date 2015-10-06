(function($){

    $(function(){
        var mainInfo = $('.main-info'),
            getNowDialog = $.dialog({
            selector:'#get-now-dialog',
            minWidth:1000,
            zindex:999,
            buttons:[
                {
                    selector: '.close',
                    event:'click',
                    callback: function(paramObj,event){
                        event.preventDefault();
                        this.hide();
                    }
                }
            ]
        });
        mainInfo.on('click','.get-now',function(event){
            event.preventDefault();
            var that = $(this),
                id = that.attr('data-id');

            $.ajax({
                url: '/detail/adopt',
                dataType: 'jsonp',
                data: {
                    petid:id
                }
            }).done(function(data){
                var success = data.success,
                    data = data.data;

                if(success){
                    var dialogContent = $('#get-now-dialog').find('.content');

                    dialogContent.html('<div class="fd-clr">'+
                                            '<span class="title">联系电话：</span>'+
                                            '<span class="text">'+data.phone+'</span>'+
                                        '</div>'+
                                        '<div class="fd-clr">'+
                                            '<span class="title">详细地址：</span>'+
                                            '<span class="text">'+data.address+'</span>'+
                                        '</div>');
                    getNowDialog.show();
                }else{

                    var timerDialog = $.dialog({
                            minWidth:1000,
                            zindex:999,
                            html: '<div style="height:45px;width:200px;text-align:center;line-height:45px;background:rgb(255,255,255);color:#ff7300;border-radius: 5px;">请先登录！</div>',
                            timers:[
                                {
                                    callback: function(){
                                        window.location.href = that.attr('href');
                                    },
                                    time: 1500
                                }
                            ]
                        });

                    timerDialog.show();
                }
            });
        });
    });

})(jQuery);