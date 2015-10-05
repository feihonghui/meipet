!(function($){

    $.namespace('Meipet.setCity');

    var initSetCity = function(){
        var dialog = $.dialog({
                selector:'#set-city-dialog',
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
            }),
            box = $('#set-city-dialog');

        box.on('click','.city-box li a',function(event){
            event.preventDefault();
            var that = $(this);
            store.set('city',that.attr('data-city'));
            window.location.reload();
        });


        Meipet.setCity = {
            dialog: dialog,
            show: function(){
                this.dialog.show();
            },
            hide: function(){
                this.dialog.hide();
            }
        };
    };

    $(function(){
        initSetCity();
    });
})(jQuery);