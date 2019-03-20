$(function(){
    //设置全局变量
    var cur = 0;    //当前的图片序号
    imgLen = $(".imgList_01 li").length;  //获取图片的数量
    timer = null;   //设置定时定时器的名字，方便后面关闭

    //当鼠标移到图片上关闭定时器，离开时则重置定时器
    $(".imgList_01").hover(function(){
        clearInterval( timer );
    },function(){
        changeImgleft( );
    });

/*    //点击向左图标根据cur进行上一个图片处理
    $(".pre").click(function(){
        cur = cur>0 ? (--cur) : (imgLen-1);
        changeTo( cur );
    });

    //点击向右图标根据cur进行上一个图片处理
    $(".next").click(function(){
        cur = cur<( imgLen-1 ) ? (++cur) : 0;
        changeTo( cur );
    });*/

    //为下方的圆点按钮绑定事件
    $(".leftlist li").hover(function(){
        clearInterval(timer);
        var index = $(this).index();
        cur = index
        changeTo(cur);
    },function(){
        changeImgleft();
    });

    //封装图片自动播放函数
    function changeImgleft(){

        timer = setInterval(function(){
            if( cur<imgLen-1 ){
                cur++;
            }else{
                cur=0;
            }
            changeTo( cur );
        },8000);
    }

    //调用函数
    changeImgleft();
    //图片切换函数
    function changeTo( num ){
        var go = num*430;
        $(".imgList_01").animate({ "left" : -go },300);
        $(".leftlist").find("li").removeClass("left_sec").eq(num).addClass("left_sec");

    }

});