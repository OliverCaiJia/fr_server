var base = {
    /*弹窗*/
    popupCover: function (opts) {
        $(".hintCover").remove();
        var defaults = {
            content: '',
            showTime: 2000,
            callback: ''
        };
        opts.callback;
        var option = $.extend({}, defaults, opts);
        var posTop = $(window).height() * .5;
        $('body').append('<div class="hintCover"><div class="hintPopup"></div></div>');
        $('.hintPopup').text(option.content);
        $('.hintCover').css({
            "position": "fixed",
            "top": 0,
            "left": 0,
            "width": 100 + "%",
            "height": 100 + "%",
            "background": "rgba(0,0,0,.2)",
            "z-index": "99999",
            "text-align": "center"
        });
        $('.hintPopup').css({
            "margin-top": posTop,
            "max-width": "6rem",
            "display": "inline-block",
            "height": ".76rem",
            "line-height": ".76rem",
            "text-align": "center",
            "background": "rgba(0, 0, 0, 0.8)",
            "color": '#fff',
            "font-size": .34 + "rem",
            "border-radius": .1 + "rem",
            "padding": "0 .35rem",
            "animation": "popupCover .12s ",
            "-webkit-animation": "popupCover .12s "
        });
        setTimeout(function () {
            $(".hintCover").fadeOut(300, option.callback);
            setTimeout(function () {
                $(".hintCover").remove();
            }, 500);
        }, .12 * 1000 + option.showTime);
    }
}
