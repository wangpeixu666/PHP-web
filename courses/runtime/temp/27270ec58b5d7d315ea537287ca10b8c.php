<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:35:"./themes/admin/coursepre\index.html";i:1529909532;s:24:"./themes/admin/base.html";i:1529678839;}*/ ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>课件征集大赛管理系统</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link rel="stylesheet" href="__JS__/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="__CSS__/font-awesome.min.css">
    <!--CSS引用-->
    
    <link rel="stylesheet" href="__CSS__/admin.css">
    <!--[if lt IE 9]>
    <script src="__CSS__/html5shiv.min.js"></script>
    <script src="__CSS__/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="layui-layout layui-layout-admin">
    <!--头部-->
    <div class="layui-header header">
        <a href=""><img class="logo" src="__STATIC__/images/admin_logo.png" alt=""></a>
        <ul class="layui-nav" style="position: absolute;top: 0;right: 20px;background: none;">
            <li class="layui-nav-item"><a href="<?php echo url('/'); ?>" target="_blank">前台首页</a></li>
            <li class="layui-nav-item"><a href="" data-url="<?php echo url('admin/system/clear'); ?>" id="clear-cache">清除缓存</a></li>
            <li class="layui-nav-item">
                <a href="javascript:;"><?php echo session('admin_name'); ?></a>
                <dl class="layui-nav-child"> <!-- 二级菜单 -->
                    <dd><a href="<?php echo url('admin/change_password/index'); ?>">修改密码</a></dd>
                    <dd><a href="<?php echo url('admin/login/logout'); ?>">退出登录</a></dd>
                </dl>
            </li>
        </ul>
    </div>

    <!--侧边栏-->
    <div class="layui-side layui-bg-black">
        <div class="layui-side-scroll">
            <ul class="layui-nav layui-nav-tree">
                <li class="layui-nav-item layui-nav-title"><a>管理菜单</a></li>
                <li class="layui-nav-item">
                    <a href="<?php echo url('admin/index/index'); ?>"><i class="fa fa-home"></i> 网站信息</a>
                </li>
                <?php if(is_array($menu) || $menu instanceof \think\Collection || $menu instanceof \think\Paginator): if( count($menu)==0 ) : echo "" ;else: foreach($menu as $key=>$vo): if(isset($vo['children'])): ?>
                <li class="layui-nav-item">
                    <a href="javascript:;"><i class="<?php echo $vo['icon']; ?>"></i> <?php echo $vo['title']; ?></a>
                    <dl class="layui-nav-child">
                        <?php if(is_array($vo['children']) || $vo['children'] instanceof \think\Collection || $vo['children'] instanceof \think\Paginator): if( count($vo['children'])==0 ) : echo "" ;else: foreach($vo['children'] as $key=>$v): ?>
                        <dd><a href="<?php echo url($v['name']); ?>"> <?php echo $v['title']; ?></a></dd>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </dl>
                </li>
                <?php else: ?>
                <li class="layui-nav-item">
                    <a href="<?php echo url($vo['name']); ?>"><i class="<?php echo $vo['icon']; ?>"></i> <?php echo $vo['title']; ?></a>
                </li>
                <?php endif; endforeach; endif; else: echo "" ;endif; ?>

                <li class="layui-nav-item" style="height: 30px; text-align: center"></li>
            </ul>
        </div>
    </div>

    <!--主体-->
    
<div class="layui-body">
    <style type="text/css">
        .layui-inline ul li{float:left;}
    </style>
    <!--tab标签-->
    <div class="layui-tab layui-tab-brief">
        <ul class="layui-tab-title">
            <li class="layui-this">初赛管理</li>
        </ul>
        <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">
                <!-- 下拉列表框 -->
                <form class="layui-form layui-form-pane" action="<?php echo url('admin/coursepre/index'); ?>" method="get">
                    <div class="layui-inline">
                        <ul id="u111" >
                            <li>
                                <a href="<?php echo url('coursepre/alldownload'); ?>" class=""><i>批量下载</i></a>
                                <a href="<?php echo url('coursepre/advanced'); ?>" class=""><i>批量晋级</i></a>
                            </li>
                            <li>
                                <select id="u825_input">
                                    <option value="全部类型">全部类型</option>
                                    <option value="个人">个人</option>
                                    <option value="团体">团体</option>
                                </select>
                            </li>
                            <li>
                                <select id="u825_input">
                                    <option value="全部状态">全部状态</option>
                                    <option value="未晋级">未晋级</option>
                                    <option value="已晋级">已晋级</option>
                                </select>
                            </li>
                            <li></li>
                        </ul>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">关键词</label>
                        <div class="layui-input-inline">
                            <input type="text" name="keyword" value="<?php echo $keyword; ?>" placeholder="请输入关键词" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <button class="layui-btn">搜索</button>
                    </div>
                </form>
            </div>
            <div class="layui-tab-item layui-show">
                <table class="layui-table">
                    <thead>
                    <tr>
                        <th><input name="checkbox" type="checkbox" value="{coursepre_list.id}" />编号</th>
                        <th>姓名</th>
                        <th>任职学校</th>
                        <!-- <th>性别</th> -->
                        <th>参赛类型</th>
                        <th>手机号码</th>
                        <th>晋级状态</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(is_array($coursepre_list) || $coursepre_list instanceof \think\Collection || $coursepre_list instanceof \think\Paginator): if( count($coursepre_list)==0 ) : echo "" ;else: foreach($coursepre_list as $key=>$vo): ?>
                        <tr>
                            <td><input name="checkbox" type="checkbox" value="<?php echo $vo['id']; ?>"/><?php echo $v['id']; ?></td>
                            <td><?php echo $vo['username']; ?></td>
                            <!--<td><?php echo $vo['genderid']=='m'? '男' : '女'; ?></td> -->
                            <td><?php echo $vo['school']; ?></td>
                            <td><?php echo $vo['cstype']==1 ? '团体' : '个人'; ?></td>
                            <td><?php echo $vo['mobile']; ?></td>
                            <td><i class="status-bar1"><?php echo $vo['advance_status']==1 ? '晋级' : '未晋级'; ?></i></td>
                            <td>
                                <?php if($vo['advance_status'] == 0): ?>
                                    <a href="<?php echo url('admin/coursepre/download',['id'=>$vo['id']]); ?>">下载</a>-
                                    <a href="">晋级</a>-
                                    <a href="<?php echo url('admin/coursepre/details',['id'=>$vo['id']]); ?>">详情</a>
                                <?php endif; if($vo['advance_status'] == 1): ?>
                                    <a href="">下载</a>
                                    <a href="<?php echo url('admin/coursepre/details',['id'=>$vo['id']]); ?>">详情</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                    </tbody>
                </table>
                <!--分页-->
                <?php echo $coursepre_list->render(); ?>
            </div>
        </div>
    </div>
</div>


    <!--底部-->
    <div class="layui-footer footer">
        <div class="layui-main">
            <p>2016-2017 &copy; <a href="https://github.com/xiayulei/open_source_bms" target="_blank">Open Source BMS</a></p>
        </div>
    </div>
</div>

<script>
    // 定义全局JS变量
    var GV = {
        current_controller: "admin/<?php echo (isset($controller) && ($controller !== '')?$controller:''); ?>/",
        base_url: "__STATIC__"
    };
</script>
<!--JS引用-->
<script src="__JS__/jquery.min.js"></script>
<script src="__JS__/layui/lay/dest/layui.all.js"></script>
<script src="__JS__/admin.js"></script>

<!--页面JS脚本-->

</body>
</html>