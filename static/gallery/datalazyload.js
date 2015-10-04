('datalazyload' in jQuery) ||
(function($){
    var WIN = window, DOC = document,
        IMGSRCNAME = 'data-lazyload-src',
        FNCLASSNAME = 'lazyload-fn',
        FNATTRIBUTE = 'data-lazyload-fn-body',
        TEXTAREACLASSNAME = 'lazyload-textarea';

    function datalazyload(){
        var _defaultThreshold = 200,
            _threshold = 0,
            options = {},
            _isRunning = false,
            _viewportHeight = 0,
            _scollBody = $(WIN),
            resourcePool = {//资源池
                img: [],
                fn: [],
                textarea: []
            },
            /*
             * 合并数组，去除重复项。
             */
            _uniqueMerge = function(des, a){
                for (var i = 0; i < a.length; i++) {
                    for (var j = 0, len = des.length; j < len; j++) {
                        if (a[i] === des[j]) {
                            a.splice(i, 1);
                            break;
                        }
                    }
                }
                $.merge(des, a);
            },
            /*
             * 遍历资源数组，剔除满足要求的项
             */
            _filter = function(array, method, context){
                var item;
                for (var i = 0; i < array.length;) {
                    item = array[i];
                    if (_checkPosition(item)) {
                        array.splice(i, 1);
                        method.call(context, item);
                    } else {
                        i++;
                    }
                }
            },
            /*
             * 函数节流
             */
            _throttle = function(method, context){
                clearTimeout(method.tId);
                method.tId = setTimeout(function(){
                    method.call(context);
                }, 100);
            },
            _bindEventAndGetViewHeight = function(){
                if (!_isRunning) {
                    _viewportHeight = _getViewportHeight();
                    _bindEvent();
                }
            },
            /*
             * 获取当前视窗高度
             */
            _getViewportHeight = function(){
                return _scollBody.height();
            },
            /*
             * 绑定滚动、窗口缩放事件
             */
            _bindEvent = function(){
                if (_isRunning) {
                    return;
                }
                _scollBody.bind('scroll.datalazyload', function(e){
                    _throttle(_loadResources);
                });
                _scollBody.bind('resize.datalazyload', function(e){
                    _viewportHeight = _getViewportHeight();
                    _throttle(_loadResources);
                });
                _isRunning = true;
            },
            /*
             * 移除滚动、窗口缩放事件
             */
            _removeEvent = function(){
                if (!_isRunning) {
                    return;
                }
                _scollBody.unbind('scroll.datalazyload');
                _scollBody.unbind('resize.datalazyload');
                _isRunning = false;
            },
            /*
             * 收集所有需要懒加载的资源
             */
            _collect = function(container){
                var imgs = $('img[' + IMGSRCNAME + ']', container).toArray(),
                    fns = $('.' + FNCLASSNAME, container).toArray(),
                    textareas = $('.' + TEXTAREACLASSNAME, container).toArray();

                _uniqueMerge(resourcePool['img'], imgs);
                _uniqueMerge(resourcePool['fn'], fns);
                _uniqueMerge(resourcePool['textarea'], textareas);
            },
            /*
             * 加载各资源
             */
            _loadResources = function(){
                _filter(resourcePool['img'], _loadImg);
                _filter(resourcePool['fn'], _runFn);
                _filter(resourcePool['textarea'], _loadTextarea);
                //如果已无资源可以加载，则清除所有懒加载事件
                if (resourcePool['img'].length === 0
                    && resourcePool['fn'].length === 0
                    && resourcePool['textarea'].length === 0) {
                    _removeEvent();
                    //that._trigger('complete');
                }
            },
            /*
             * 加载图片
             */
            _loadImg = function(el){
                var src;
                el = $(el);
                src = el.attr(IMGSRCNAME);
                if (src) {
                    //el.css('display', 'none');

                    el.one('load', function(){
                        $(this).css('zoom', 1);
                    });

                    el.attr('src', src);

                    el.removeAttr(IMGSRCNAME);
                    //el.load(function(){
                    //    $(this).fadeIn('show');
                    //});
                }
            },
            /*
             * 执行异步函数
             */
            _runFn = function(a){
                var el, fn, fnStr;
                if ($.isArray(a)) {
                    el = a[0];
                    fn = a[1];
                } else {
                    el = a;
                }
                if (fn) {
                    fn(el);
                }
                el = $(el);
                fnStr = el.attr(FNATTRIBUTE);
                if (fnStr) {
                    fn = _parseFunction(fnStr);
                    fn(el);
                    el.removeAttr(FNATTRIBUTE);
                }
            },
            /*
             * 从指定的textarea元素中提取内容，并将它渲染到页面上
             */
            _loadTextarea = function(el){
                el = $(el);
                el.html($('textarea', el).val());
            },
            /*
             * 将字符串转化为可以执行的函数
             */
            _parseFunction = function(s){
                var a = s.split('.'), l = a.length, o = WIN;
                for (var i = ($.isWindow(a[0]) ? 1 : 0); i < l; i++) {
                    if ($.isFunction(o[a[i]]) || $.isPlainObject(o[a[i]])) {
                        o = o[a[i]];
                    } else {
                        return null;
                    }
                }
                if ($.isFunction(o)) {
                    return o;
                }
                return null;
            },
            /*
             * 判断元素是否已经到了可以加载的地方
             */
            _checkPosition = function(el){
                var ret = false,
                    currentScrollTop = $(DOC).scrollTop(),
                    benchmark = currentScrollTop + _viewportHeight + _threshold, currentOffsetTop = $(el).offset().top;
                if (currentOffsetTop <= benchmark) {
                    ret = true;
                }
                return ret;
            },
            _toFnArray = function(els, fn){
                var ret = [], l;
                if (!els) {
                    return ret;
                }
                l = els.length;
                if (!l) {
                    ret.push([els, fn]);
                } else if (l > 0) {
                    for (var i = 0; i < l; i++) {
                        ret.push([els[i], fn])
                    }
                }
                return ret;
            };
        return {
            /**
             * 初始化
             */
            init: function(){
                _bindEventAndGetViewHeight();
                _loadResources();
            },
            /*
             * 注册
             */
            register: function(options){
                var containers = options.containers;
                _threshold = options.threshold || _defaultThreshold;
                for (var i = 0, l = containers.length; i < l; i++) {
                    this.bind(containers[i], $.proxy(this.add, this));
                }
                this.init();
            },
            /*
             * 添加需要懒加载的资源
             */
            add: function(container){
                _collect(container);
                this.init();
            },
            /*
             * 将异步触发函数绑定在浮标元素上，即坐标元素一曝光就触发该函数。
             */
            bind: function(el, fn){
                _bindEventAndGetViewHeight();
                var els = _toFnArray(el, fn);
                if (els.length === 0) {
                    return;
                }
                _uniqueMerge(resourcePool['fn'], els);
                _loadResources();
            }
        }
    };
    $.datalazyload = datalazyload();

    $(function(){
        $.datalazyload.add($('body'));
    });
})(jQuery);