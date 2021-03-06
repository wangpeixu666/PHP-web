<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:38:"./themes/admin/system\site_config.html";i:1490664232;s:24:"./themes/admin/base.html";i:1532415529;}*/ ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--    <meta name="viewport" content="width=device-width,initial-scale=1" />-->
	<link href="__STATIC__/images/title.png" rel="shortcut icon">
    <title>课件征集大赛管理系统</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link rel="stylesheet" href="__JS__/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="__CSS__/font-awesome.min.css">
    <link rel="stylesheet" href="__CSS__/jcDate.css">
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
    <!--tab标签-->
    <div class="layui-tab layui-tab-brief">
        <ul class="layui-tab-title">
            <li class="layui-this">站点配置</li>
        </ul>
        <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">
                <form class="layui-form form-container" action="<?php echo url('admin/system/updateSiteConfig'); ?>" method="post">
                    <div class="layui-form-item">
                        <label class="layui-form-label">网站标题</label>
                        <div class="layui-input-block">
                            <input type="text" name="site_config[site_title]" value="<?php echo (isset($site_config['site_title']) && ($site_config['site_title'] !== '')?$site_config['site_title']:''); ?>" required  lay-verify="required" placeholder="请输入网站标题" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">SEO标题</label>
                        <div class="layui-input-block">
                            <input type="text" name="site_config[seo_title]" value="<?php echo (isset($site_config['seo_title']) && ($site_config['seo_title'] !== '')?$site_config['seo_title']:''); ?>" placeholder="请输入SEO标题" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">SEO关键字</label>
                        <div class="layui-input-block">
                            <input type="text" name="site_config[seo_keyword]" value="<?php echo (isset($site_config['seo_keyword']) && ($site_config['seo_keyword'] !== '')?$site_config['seo_keyword']:''); ?>" placeholder="请输入SEO关键字" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">SEO说明</label>
                        <div class="layui-input-block">
                            <textarea name="site_config[seo_description]" placeholder="请输入SEO说明" class="layui-textarea"><?php echo (isset($site_config['seo_description']) && ($site_config['seo_description'] !== '')?$site_config['seo_description']:''); ?></textarea>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">版权信息</label>
                        <div class="layui-input-block">
                            <input type="text" name="site_config[site_copyright]" value="<?php echo (isset($site_config['site_copyright']) && ($site_config['site_copyright'] !== '')?$site_config['site_copyright']:''); ?>" placeholder="请输入版权信息" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">ICP备案号</label>
                        <div class="layui-input-block">
                            <input type="text" name="site_config[site_icp]" value="<?php echo (isset($site_config['site_icp']) && ($site_config['site_icp'] !== '')?$site_config['site_icp']:''); ?>" placeholder="请输入版权信息" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">统计代码</label>
                        <div class="layui-input-block">
                            <textarea name="site_config[site_tongji]" placeholder="请输入统计代码" class="layui-textarea"><?php echo (isset($site_config['site_tongji']) && ($site_config['site_tongji'] !== '')?$site_config['site_tongji']:''); ?></textarea>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <button class="layui-btn" lay-submit lay-filter="*">提交</button>
                            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


    <!--底部-->
    <div class="layui-footer footer">
        <div class="layui-main">
            <p>2016-2018 &copy; <a href="https://github.com/xiayulei/open_source_bms" target="_blank">Open Source BMS</a></p>
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
<script src="__JS__/jcdate/jquery.min.js"></script>
<script src="__JS__/jcdate/jQuery-jcDate.js"></script>
<!--<script src="__JS__/jquery.min.js"></script>-->
<script src="__JS__/layui/lay/dest/layui.all.js"></script>
<script src="__JS__/admin.js"></script>

<!--页面JS脚本-->

</body>
</html>