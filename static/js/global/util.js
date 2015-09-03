var Meipet = {};

Meipet.util = {};

Meipet.util.paramsToJSON = function(){
    var $u = location.search.slice(1),
        r = {};
    if( !!$u ){
        $u = $u.split("&");
    } else {
        return r;
    }
    jQuery.each($u, function ( el ){
        var $n = el.split("=");
        r[$n[0]] = $n[1];
    });
    return r;
};

Meipet.util.jsonToParams = function( obj ){
    var $l = location.protocol + "//" + location.hostname + location.pathname;
    if($.isPlainObject(obj) && !$.isEmptyObject(obj)){
        var $k = _.keys(obj),
            $v = _.values(obj),
            $r = "",
            $max = $k.length - 1;

        _.each($k, function (el, i){
            $r = $r + el + "=" + $v[i];
            if( i < $max ){
                $r += "&";
            }
        });
        return $l + "?" + $r + location.hash;
    } else {
        return $l + location.hash;
    }
};


