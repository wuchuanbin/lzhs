<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<head>
<meta charset="utf-8">
<title></title>
<meta name="Keywords" content="">
<meta name="Description" content="">
<link rel="stylesheet" href="__PUBLIC__/css/idangerous.swiper.css">
<link rel="stylesheet" href="__PUBLIC__/css/960.css">
<link id="css" href="" rel="stylesheet" type="text/css">
<script>document.getElementById('css').href = '__PUBLIC__/css/css.css?' + Math.random();</script>
    <script>
            function login(){
                $('#loginForm').submit();
            }
        </script>
</head>

<body>
<div class="container_16">
    <div class="login-box">
        <?php if($_SESSION['uid']> 0): ?><div class="islogin login" style="display: inline">
                <p>欢迎，<span><?php echo ($_SESSION['userInfo']['user_name']); ?></span>。
                    <span class="goblackboard pointer">
                        <?php if($_SESSION['userInfo']['is_admin']== 1): ?><a href="/index.php?m=Manager&a=index">进入教学平台系统</a>
                            <?php else: ?>
                            <a href="/index.php?m=User&a=index">我的主页</a><?php endif; ?>
                    ｜ <a href="/index.php?m=Login&a=logOut"> 退出</a></span></p>
            </div>
            <?php else: ?>
        <div class="notlogin login">
            <form action="/index.php?m=Login&a=login" method="post" id="loginForm">
            <input type="text" placeholder="用户名" name="user_name" class="inline"><input type="password" name="password" placeholder="密码" class="inline"><a href="javascript:login();" class="submit button hover">登陆</a></div>
            </form><?php endif; ?><!--  -->
    </div>
    <div class="clear"></div> 
    <div class="grid_16 logo-box"></div>
    <div class="clear"></div>
    <div class="grid_16 nav-box">
        <ul>
            <li><a class="hover" href="javascript:;">首页</a></li>
            <li><a class="hover" href="javascript:;">学校简介</a></li>
            <li><a class="hover" href="javascript:;">作品欣赏</a></li>
            <li><a class="hover" href="javascript:;">光荣榜</a></li>
        </ul>
    </div>
    <div class="clear"></div>
    <div class="grid_4 sidebar-box">
        <div class="sec-box">
            <h3>画室简介</h3>
            <p>这是一些虚拟的内容u know,这是一些虚拟的内容u know,这是一些虚拟的内容u know,这是一些虚拟的内容u know,这是一些虚拟的内容u know</p>
        </div>
        <div class="sec-box">
            <h3>画室成绩</h3>
            <a href="javascript:;">这是一个链接</a>
            <a href="javascript:;">这是一个链接</a>
            <a href="javascript:;">这是一个链接</a>
        </div>
    </div>
    <div class="grid_8 cont-box">
        <div class="img-box"></div>
        <div class="sec-box">
            <h2>画室新闻</h2>
            <a href="javascript:;">这是一个链接他会长得很长 你说是不是亚麻是不是呀嘛嘿(可能还会有日期哟嘿)</a>
            <a href="javascript:;">这是一个链接</a>
            <a href="javascript:;">这是一个链接</a>
        </div>
        <div class="sec-box">
            <h2>作品展示</h2>
            <div class="img-box"></div>
            <div class="img-box"></div>
            <div class="img-box last"></div>
            <div class="clear"></div>
            <div class="img-box"></div>
            <div class="img-box"></div>
            <div class="img-box last"></div>
            <div class="clear"></div>
        </div>
        <div class="sec-box">
            <h2>高考专栏</h2>
            <a href="javascript:;">这是一个链接</a>
            <a href="javascript:;">这是一个链接</a>
            <a href="javascript:;">这是一个链接</a>
        </div>
        <div class="sec-box">
            <h2>画室环境</h2>
            <div class="img-box"></div>
            <div class="img-box"></div>
            <div class="img-box last"></div>
            <div class="clear"></div>
            <div class="img-box"></div>
            <div class="img-box"></div>
            <div class="img-box last"></div>
            <div class="clear"></div>
        </div>
    </div>
    <div class="grid_4 sidebar-box">
        <div class="sec-box">
            <h3>画室简介</h3>
            <p>这是一些虚拟的内容u know,这是一些虚拟的内容u know,这是一些虚拟的内容u know,这是一些虚拟的内容u know,这是一些虚拟的内容u know</p>
        </div>
        <div class="sec-box">
            <h3>画室成绩</h3>
            <a href="javascript:;">这是一个链接</a>
            <a href="javascript:;">这是一个链接</a>
            <a href="javascript:;">这是一个链接</a>
        </div>
    </div>
</div>

<div class="bg"></div>

<script src="__PUBLIC__/js/jquery-1.9.1.min.js"></script>
<script src="__PUBLIC__/js/idangerous.swiper.min.js"></script>
<script src="__PUBLIC__/js/js.js?111"></script>

</body>
</html>