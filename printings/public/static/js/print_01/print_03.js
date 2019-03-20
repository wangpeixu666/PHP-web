$(function(){
    //设置全局变量
    var cur = 0;    //当前的图片序号
    imgLen = $(".imgList_02 li").length;  //获取图片的数量
    timer = null;   //设置定时定时器的名字，方便后面关闭

    //当鼠标移到图片上关闭定时器，离开时则重置定时器
    $(".imgList_02").hover(function(){
        clearInterval( timer );
    },function(){
        changeImg( );
    });

    //为下方的圆点按钮绑定事件
    $(".rightlist li").hover(function(){
        clearInterval(timer);
        var index = $(this).index();
        cur = index
        changeTo(cur);
    },function(){
        changeImg();
    });

    //封装图片自动播放函数
    function changeImg(){

        timer = setInterval(function(){
            if( cur<imgLen-1 ){
                cur++;
            }else{
                cur=0;
            }
            changeTo( cur );
        },10000);
    }

    //调用函数
    changeImg();
    //图片切换函数
    function changeTo( num ){
        var go = num*480;
        $(".imgList_02").animate({ "left" : -go },300);
        $(".rightlist").find("li").removeClass("right_sec").eq(num).addClass("right_sec");

    }

});