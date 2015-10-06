(function($){
    $(function(){
        $(document).on('click','a.add-from',function(event){
            event.preventDefault();
            var that = $(this),
                url = that.attr('href'),
                fromUrl = decodeURI(Meipet.urlTool.paramsToJSON()['from']);
            if(fromUrl === 'undefined'){
                fromUrl = '/';
            };
            window.location.href = url + '?from=' + fromUrl;
        });
    });
})(jQuery);