(function($,urlTool){
	$(function(){
        var urlParams = urlTool.paramsToJSON(),
            category = urlParams.category || '',
            city = store.get('city') || '',
            area = urlParams.area || '',
            prevHasDone = false;

        area = decodeURI(area);

        if(city === ''){
            city = '杭州';
            Meipet.setCity.show();
        };
        
        var requestParams = {
            category: category,
            area: area,
            city: city,
            page: 1,
            size: 20
        };

        function initSn(){
            var snItem = $('.sn-item');
            if(category !== ''){
                snItem.find('a').removeClass('selected');
                snItem.find('.' + category).addClass('selected');
            }
        };

        function initPosition(){
            var positionBox = $('.position'),
                cityElm = positionBox.find('.city'),
                zoneBox = positionBox.find('.zone'),
                html = '';
            var urlParams = urlTool.paramsToJSON();
            positionBox.on('click','.swich-city',function(event){
                event.preventDefault();
                Meipet.setCity.show();
            });
            cityElm.text(city);

            $.ajax({
                url: '/attribute/getAreaList',
                dataType: 'jsonp',
                data: {
                    city: city
                }
            }).done(function(dataIn) {
                var cityList = dataIn.data;
                if(!cityList){
                    return;
                }
                cityList.splice(0,0,{
                    area: "全部",
                    city: city,
                    id: 0,
                    order: 0
                });

                $.each(cityList,function(key,val){

                    var url,
                        varea = val.area;

                    urlParams['area'] = varea;

                    if(varea === '全部'){
                        urlParams['area'] = '';
                    }

                    url = urlTool.jsonToParams(urlParams);

                    if(varea === '全部' && area === ''){
                        html = html + '<a href="'+ url +'" class="selected">全部</a>';
                    }else{

                        if(varea === area){
                            html = html + '<a href="'+ url +'" class="selected">'+ varea +'</a>';
                        }else{
                            html = html + '<a href="'+ url +'" >'+ varea +'</a>';
                        }
                    }
                });

                zoneBox.html(html);
            });
        };

        var listBox = $('.offer-list'),
            noMore = $('.no-more');
        function rendOffer(){
            $.ajax({
                url: '/list/getPet',
                dataType: 'jsonp',
                data: requestParams
            }).done(function(dataIn) {
                var data = dataIn.data;
                if( dataIn.result && data && data.length > 0){
                    listBox.append(template('list-template', dataIn));
                    prevHasDone = true;
                }else{
                    noMore.text('没有更多了...');
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
                        requestParams.page = requestParams.page + 1;
                        prevHasDone = false;
                        rendOffer(requestParams);
                    }

                }
            });
        };

        function pageLoaded(){
            initSn();
            initPosition();
            rendOffer();
            initScroll();
        };

        pageLoaded();
    });
	
})(jQuery,Meipet.urlTool);