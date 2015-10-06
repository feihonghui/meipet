!(function($){

    function Dialog(config){
        var buttons = config.buttons,
            elm = config.elm,
            that = this;
        elm.appendTo('body');

        //干死ie6
        this.ie6 = !$.support.style;
        if(this.ie6){
            elm.css({
                'position': 'absolute',
                'z-index': config.zindex
            });
        }else{
            elm.css({
                'position': 'fixed',
                'z-index': config.zindex
            });
        };

        if (typeof buttons !== 'undefined') {
            $.each(buttons, function(index, val) {
                elm.on(val.event, val.selector, function(event) {
                    val.callback.call(that,val.paramObj,event);
                });
            });
        };

        this.config = config;

        //干死ie6
        if(this.ie6){
            this.selectVisible = $('select:visible');
        }

        this.show = function(conf){
            var that = this,
                config = that.config,
                win = $(window);

            config.elm.show(0);
            //干死ie6
            if(this.ie6) {
                this.selectVisible.css({
                    'visibility': 'hidden'
                });
            }
            if(typeof conf !== 'undefined' && conf.showMask === false){

            }else{
                this.modal(config.mask,config.minWidth);
                $('html').css({
                    overflow:'hidden'
                });
            }

            this.center(config.elm);
            win.on('resize.'+config.id, function(event) {
                that.modal(config.mask,config.minWidth);
                that.center(config.elm);
            });

            if(typeof config.timers !== 'undefined'){
                var timersId = [];
                $.each(config.timers, function(index, val) {
                    timersId.push(setTimeout(function(){
                        val.callback.call(that,val.paramObj);
                    },val.time));
                });
                config.timersId = timersId;
            };

        };

        this.hide = function(conf){
            var config = this.config,
                win = $(window),
                timersId = config.timersId;

            //干死ie6
            if(this.ie6) {
                this.selectVisible.css({
                    'visibility': 'visible'
                });
            }
            win.off('resize.'+config.id);
            if(typeof conf !== 'undefined' && conf.hideMask === false){

            }else{
                config.mask.hide(0);
                $('html').css({
                    overflow:'auto'
                });
            }
            config.elm.hide(0);
            if(typeof timersId !== 'undefined'){
                $.each(timersId, function(index, val) {
                    clearInterval(val);
                });
            }
        };

        this.destroy = function(){
            var config = this.config;
            if(config.htmlFlag){
                config.elm.remove();
            }
            config.mask.remove();
        };
    };

    Dialog.prototype.modal = function(elm,minWidth){
        var doc = $(document),
            height = doc.height(),
            width = $(window).width();
        if(typeof minWidth !== 'undefined' && minWidth > width){
            width = minWidth;
        }
        elm.width(width);
        elm.height(height);
        elm.show(0);
    };

    Dialog.prototype.center = function(elm,minWidth){
        function client(){
            var winWidth,
                winHeight;
            //获取窗口宽度
            if (window.innerWidth){
                winWidth = window.innerWidth;
            } else if ((document.body) && (document.body.clientWidth)){
                winWidth = document.body.clientWidth;
            }

            //获取窗口高度
            if (window.innerHeight){
                winHeight = window.innerHeight;
            } else if ((document.body) && (document.body.clientHeight)){
                winHeight = document.body.clientHeight;
            }

            return {
                width: winWidth,
                height: winHeight
            }
        };

        var win = $(window),
            height = elm.height(),
            width = elm.width();
        var client = client();
            winWidth = client.width,
            winHeight = client.height;


        if(typeof minWidth !== 'undefined' && minWidth > winWidth){
            winWidth = minWidth;
        }
        var centerLeft = (winWidth - width)/2,
            centerTop = (winHeight - height)/2;

        //干死ie6
        if(this.ie6){
            centerTop = centerTop + $(document).scrollTop();
        }

        elm.css({
            'top': centerTop+'px',
            'left': centerLeft+'px'
        });
    };

    function dialog(config){
        var mask = $('<div></div>'),
            elm;
        mask.appendTo('body');
        mask.css({
            'position': 'absolute',
            'background': '#333',
            'top': '0px',
            'left': '0px',
            'z-index': config.zindex - 1
        }).animate({
            opacity:.7
        },0);

        config.id = 'dialog'+new Date().getTime();

        if(typeof config.selector !== 'undefined'){
            elm = $(config.selector);
        }else if(typeof config.html !== 'undefined'){
            elm = $(config.html);
            config.htmlFlag = true;
        };

        var dialogConfig = {
            elm: elm,
            id: config.id,
            mask: mask,
            minWidth: config.minWidth,
            timers: config.timers,
            buttons:config.buttons,
            zindex:config.zindex
        };


        return new dialog.prototype.init(dialogConfig);
    };

    dialog.prototype.init = Dialog;

    $.dialog ? $.dialog : $.dialog = dialog;
})(jQuery);