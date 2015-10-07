(function($){
	$(function(){
		var myPetList = $('#my-pet-list'),
			page = 1,
			prevHasDone = false,
            leftMore = $('.left-more');
		function rendOffer(){
			$.ajax({
				url: '/admin/manage/myPetList',
				dataType: 'jsonp',
				data: {
					page: page
				}
			})
			.done(function(dataIn) {
				console.log(dataIn);
				var data = dataIn.data;
				if( dataIn.success && data && data.length > 0){
                    myPetList.append(template('list-template', dataIn));
                    prevHasDone = true;
                    leftMore.html('');
                }else{
                    if(page > 1){
                        leftMore.html('没有更多了...');
                    }
                }
			});
		};

		function initScroll(){
            var win = $(window),
                dom = $(document);

            win.scroll(function(){
                var domHeight = dom.height(),
                    winHeight = window.innerHeight,
                    scrollHeight = dom.scrollTop();

                if(domHeight < (winHeight + scrollHeight + 100)){
                    if(prevHasDone){
                        page = page + 1;
                        prevHasDone = false;
                        rendOffer();
                    }

                }
            });
        };

        myPetList.on('click', 'a.delete', function(event) {
        	event.preventDefault();
        	var that = $(this),
        		id = that.attr('data-id');
            if(confirm("确定要删除该宠物？")){
                $.ajax({
                    url: '/admin/manage/delPet',
                    dataType: 'jsonp',
                    data: {
                        'petid': id
                    }
                })
                .done(function(dataIn) {
                    if(dataIn.success && !dataIn.data){
                        that.parent('.list-item').remove();
                    }else{
                        alert(dataIn.data);
                    }
                });
            }
        	
        });
        rendOffer();
        initScroll();
	});
})(jQuery);