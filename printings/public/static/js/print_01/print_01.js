$(function(){
    //设置全局变量
    var mur = 0;    //当前的图片序号
    imgLennum = $(".imgList li").length;  //获取图片的数量
    timer = null;   //设置定时定时器的名字，方便后面关闭

/*    //当鼠标移到向左和向右的图标上关闭定时器，离开时则重置定时器
    $(".pre,.next").hover(function(){
        clearInterval( timer );
    },function(){
        changeImglist( );
    });*/

    //当鼠标移到图片上关闭定时器，离开时则重置定时器
    $(".imgList").hover(function(){
        clearInterval( timer );
    },function(){
        changeImglist( );
    });
    /*
    //点击向左图标根据cur进行上一个图片处理
    $(".pre").click(function(){
        mur = mur>0 ? (--mur) : (imgLennum-1);
        changeTo( mur );
    });

    //点击向右图标根据cur进行上一个图片处理
    $(".next").click(function(){
        mur = mur<( imgLennum-1 ) ? (++mur) : 0;
        changeTo( mur );
    });
    */
    //为下方的圆点按钮绑定事件
    $(".dollList li").hover(function(){
        clearInterval(timer);
        var index = $(this).index();
        mur = index;
        changeTo(mur);
    },function(){
        changeImglist();
    });

    //封装图片自动播放函数
    function changeImglist(){

        timer = setInterval(function(){
            if( mur<imgLennum-1 ){
                mur++;
            }else{
                mur=0;
            }
            changeTo( mur );
        },4000);
    }

    //调用函数
    changeImglist();

    //图片切换函数
    function changeTo( num ){
        var go = num*1920;
        $(".imgList").animate({ "left" : -go },350);
        $(".dollList").find("li").removeClass("sec").eq(num).addClass("sec");

    }

});