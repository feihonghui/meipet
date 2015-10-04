(function($){

    $.extend({
        'namespace':function(str){
            var strArr = str.split('.'),
                size = strArr.length,
                temp = {};

            for(var i = 0; i < size; i++){
                if(i === 0){
                    window[strArr[i]] = {};
                    temp = window[strArr[i]];
                }else{
                    temp[strArr[i]] = {};
                    temp = temp[strArr[i]];
                }
            }
        }
    });

    $.namespace('Meipet.urlTool');
    $.extend(Meipet.urlTool, {
        paramsToJSON: function(){
            var $u = location.search.slice(1),
                r = {};
            if( !!$u ){
                $u = $u.split("&");
            } else {
                return r;
            }
            $.each($u, function ( i, el ){
                var $n = el.split("=");
                r[$n.shift()] = $n.join('=');
            });
            return r;
        },
        jsonToParams: function( obj ){
            var $l = location.protocol + "//" + location.hostname + location.pathname;
            if($.isPlainObject(obj) && !$.isEmptyObject(obj)){
                var $k = [],
                    $v = [],
                    $r = "",
                    $max;

                for(var key in obj){
                    $k.push(key);
                    $v.push(obj[key]);
                };

                $max = $k.length - 1;

                $.each($k, function (i,el){
                    $r = $r + el + "=" + $v[i];
                    if( i < $max ){
                        $r += "&";
                    }
                });
                return $l + "?" + $r + location.hash;
            } else {
                return $l + location.hash;
            }
        }
    });

})(jQuery);