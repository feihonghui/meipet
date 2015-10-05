(function($){

    $(function(){
        var mainInfo = $('.main-info');
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

                }else{
                    window.location.href = that.attr('href');
                }
            });
        });
    });

})(jQuery);