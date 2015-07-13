(function($) {
    function initOptionPos() {
        function resetOptionPos() {
            var winHeight = window.innerHeight,
                beautyBar = $("#beautyBar"),
                beautyFooter = $("#beautyFooter"),
                leftHeight = winHeight - beautyBar.height() - beautyFooter.height(),
                option = $("#indexContent").find('.option'),
                marginTop = (leftHeight - option.height()) / 2;

            if (marginTop < 0) {
                marginTop = 0;
            }
            marginTop = marginTop + beautyBar.height();

            option.css({
                "margin-top": marginTop + 'px'
            });
        }

        resetOptionPos();
        $(window).on('resize', function(event) {
            resetOptionPos();
        });
    }

    function initTab() {
        var indexContent = $('#indexContent'),
            tabTitle = indexContent.find('.tab-title'),
            contentBoxList = indexContent.find('.tab-content .content-box');

        tabTitle.on('click', 'li', function(event) {
            event.preventDefault();
            var that = $(this),
                currentContentBox = contentBoxList.eq(that.index());
            if (!that.hasClass('current')) {
                that.addClass('current').siblings('li').removeClass('current');
                currentContentBox.siblings('.content-box').css({
                    "width": "0px",
                    "display": "none",
                    "opacity": 0,
                    "overflow": "hidden"
                });
                currentContentBox.css({
                    "display": "block"
                }).animate({
                    width: 692,
                    opacity: 1
                }, 200, function() {
                    currentContentBox.css({
                        "overflow": "visible"
                    });
                });
            }
        });
    }

    $(function() {
        initOptionPos();
        initTab();
    });
})(jQuery);