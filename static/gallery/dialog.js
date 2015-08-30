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

        this.show = function(){
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
            this.modal(config.mask,config.minWidth);
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
            }
        };

        this.hide = function(){
            var config = this.config,
                win = $(window),
                timersId = config.timersId;

            //干死ie6
            if(this.ie6) {
                this.selectVisible.css({
                    'visibility': 'visible'
                });
            }

            config.mask.hide(0);
            config.elm.hide(0);
            win.off('resize.'+config.id);
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
        var win = $(window),
            height = elm.height(),
            width = elm.width(),
            winWidth = win.width(),
            winHeight = win.height();

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
            'background': '#000',
            'top': '0px',
            'left': '0px',
            'z-index': config.zindex - 1
        }).animate({
            opacity:.3
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