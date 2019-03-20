//动态和新闻显示隐藏模块js  author wangpeixu
$(function () {
    // 鼠标移动到left_b的button上的时候显示main_ul_02
    $("#main_ul_02").hide();
    $("#left_input02").hide();
    $("#left_b").hover(function () {
        $("#left_a").css({"background":"none",
            "cursor":"pointer",
            "color":"#A52A2A",
            "border": "1px solid #A52A2A",
        });
        $("#left_b").css({
            "background-color":"#8B0000",
            "cursor":"pointer",
            "color":"#FFFFFF",
            "border": "none",
        });
        $("#left_input02").show();
        $("#left_input01").hide();

        $("#main_ul_02").show();
        $("#main_ul_01").hide();

    }, function () {
        $("#left_b").css({
            "background-color":"#8B0000",
            "cursor":"pointer",
            "color":"#FFFFFF",
            "border": "none",
        });
        $("#main_ul_02").show();
    });
    // 鼠标移动到left_a的button上的时候显示main_ul_01
    $("#left_a").hover(function () {
        $("#left_b").css({"background":"none",
            "cursor":"pointer",
            "color":"#A52A2A",
            "border": "1px solid #A52A2A",
        });
        $("#left_a").css({
            "background-color":"#8B0000",
            "cursor":"pointer",
            "color":"#FFFFFF",
            "border": "none",
        });
        $("#left_input01").show();
        $("#left_input02").hide();

        $("#main_ul_01").show();
        $("#main_ul_02").hide();

    }, function () {
        $("#left_a").css({
            "background-color":"#8B0000",
            "cursor":"pointer",
            "color":"#FFFFFF",
            "border": "none",
        });
        $("#main_ul_01").show();
    });

    // 鼠标移动到right_b的button上的时候显示main_ul_04
    $("#main_ul_04").hide();
    $("#right_input04").hide();
    $("#right_b").hover(function () {
        $("#right_a").css({"background":"none",
            "cursor":"pointer",
            "color":"#A52A2A",
            "border": "1px solid #A52A2A",
        });
        $("#right_b").css({
            "background-color":"#8B0000",
            "cursor":"pointer",
            "color":"#FFFFFF",
            "border": "none",
        });
        $("#right_input04").show();
        $("#right_input03").hide();

        $("#main_ul_04").show();
        $("#main_ul_03").hide();
    }, function () {
        $("#right_b").css({
            "background-color":"#8B0000",
            "cursor":"pointer",
            "color":"#FFFFFF",
            "border": "none",
        });
        $("#main_ul_04").show();
    });
    // 鼠标移动到right_a的button上的时候显示main_ul_03
    $("#right_a").hover(function () {
        $("#right_b").css({"background":"none",
            "cursor":"pointer",
            "color":"#A52A2A",
            "border": "1px solid #A52A2A",
        });
        $("#right_a").css({
            "background-color":"#8B0000",
            "cursor":"pointer",
            "color":"#FFFFFF",
            "border": "none",
        });
        $("#right_input03").show();
        $("#right_input04").hide();

        $("#main_ul_03").show();
        $("#main_ul_04").hide();
    }, function () {
        $("#right_a").css({
            "background-color":"#8B0000",
            "cursor":"pointer",
            "color":"#FFFFFF",
            "border": "none",
        });
        $("#main_ul_03").show();
    });



});