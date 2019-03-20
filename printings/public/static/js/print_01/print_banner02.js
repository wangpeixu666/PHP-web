$(".fullSlide").hover(function(){
        $(this).find(".prev,.next").stop(true, true).fadeTo("show", 1.0)
    },
    function(){
        $(this).find(".prev,.next").fadeOut()
    });
$(".fullSlide").slide({
    titCell: ".hd ul",
    mainCell: ".bd ul",
    effect: "fold",
    autoPlay: false,//是否自动播放
    autoPage: true,
    trigger: "mouseover",//鼠标点击click事件和经过事件
    startFun: function(i) {
        var curLi = jQuery(".fullSlide .bd li").eq(i);
        if ( !! curLi.attr("src")) {
            curLi.css("background-image", curLi.attr("src")).removeAttr("src")
        }
    }
});