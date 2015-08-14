<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>txlz Admin</title>
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="stylesheet" type="text/css" href="__PUBLIC__/lib/bootstrap/css/bootstrap.css">
	<!-- <link rel="stylesheet" type="text/css" href="__PUBLIC__/lib/bootstrap/css/bootstrap-responsive.css"> -->
    <link rel="stylesheet" type="text/css" href="__PUBLIC__/css/theme.css">
    <link rel="stylesheet" href="__PUBLIC__/lib/font-awesome/css/font-awesome.css">

    <script src="__PUBLIC__/lib/jquery-1.8.1.min.js" type="text/javascript"></script>

    <!-- Demo page code -->

    <style type="text/css">
        #line-chart {
            height:300px;
            width:800px;
            margin: 0px auto;
            margin-top: 1em;
        }
        .brand { font-family: georgia, serif; }
        .brand .first {
            color: #ccc;
            font-style: italic;
        }
        .brand .second {
            color: #fff;
            font-weight: bold;
        }
    </style>

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="__PUBLIC__/js/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="../assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
</head>

<!--[if lt IE 7 ]> <body class="ie ie6"> <![endif]-->
<!--[if IE 7 ]> <body class="ie ie7"> <![endif]-->
<!--[if IE 8 ]> <body class="ie ie8"> <![endif]-->
<!--[if IE 9 ]> <body class="ie ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<body>
<!--<![endif]-->

<div class="navbar">
    <div class="navbar-inner">
        <div class="container-fluid">
            <ul class="nav pull-right">

                <li id="fat-menu" class="dropdown">
                    <a href="#" id="drop3" role="button" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-user"></i> 管理员
                        <i class="icon-caret-down"></i>
                    </a>

                    <ul class="dropdown-menu">
                        <li><a tabindex="-1" href="#">设置</a></li>
                        <li class="divider"></li>
                        <li><a tabindex="-1" href="/index.php?m=Login&a=logOut">退出</a></li>
                    </ul>
                </li>

            </ul>
            <a class="brand" href="/"><span class="first">桐乡</span> <span class="second">老志画室</span></a>
        </div>
    </div>
</div>


<div class="container-fluid">

    <div class="row-fluid">
        <div class="span3">
            <div class="sidebar-nav">
                <div class="nav-header" data-toggle="collapse" data-target="#dashboard-menu"><i class="icon-dashboard"></i>人员管理</div>
                <ul id="dashboard-menu" class="nav nav-list collapse in">
                    <li><a href="/index.php?m=Manager&a=UserList">学生列表</a></li>
                    <li ><a href="/index.php?m=Manager&a=UserList&type=teacher">老师列表</a></li>
                    <li ><a href="/index.php?m=Manager&a=UserList&type=admin">管理员列表</a></li>
                    <!--<li ><a href="gallery.html">Gallery</a></li>
                    <li ><a href="calendar.html">Calendar</a></li>
                    <li ><a href="faq.html">Faq</a></li>
                    <li ><a href="help.html">Help</a></li>-->

                </ul>
                <div class="nav-header" data-toggle="collapse" data-target="#accounts-menu"><i class="icon-briefcase"></i>班级管理<!--<span class="label label-info">+10</span>--></div>
                <ul id="accounts-menu" class="nav nav-list collapse in">
                    <li ><a href="<?php echo U('cate/index?flag=class'); ?>">班级列表</a></li>
                    <li ><a href="<?php echo U('Message/index'); ?>">班级通知</a></li>
                    <li ><a href="<?php echo U('Class/photoList');?>">班级相册</a></li>
                </ul>

                <div class="nav-header" data-toggle="collapse" data-target="#settings-menu"><i class="icon-exclamation-sign"></i>文章管理</div>
                <ul id="settings-menu" class="nav nav-list collapse in">
                    <li ><a href="<?php echo U('cate/index?flag=article'); ?>">文章分类</a></li>
                    <li ><a href="<?php echo U('article/index'); ?>">文章列表</a></li>
                    <!--<li ><a href="500.html">500 page</a></li>
                    <li ><a href="503.html">503 page</a></li>-->
                </ul>

                <div class="nav-header" data-toggle="collapse" data-target="#legal-menu"><i class="icon-legal"></i>作品管理</div>
                <ul id="legal-menu" class="nav nav-list collapse in">
                    <li ><a href="/index.php?m=Manager&a=HomeWorkList">历史作业</a></li>
                    <li ><a href="/index.php?m=Manager&a=UpWork">批量上传作品</a></li>
                </ul>
            </div>
        </div>


<div class="span9">
    <h1 class="page-title">文章列表</h1>
    <div class="btn-toolbar">
        <a href="<?php echo U('article/add'); ?>" style='color:#fff;'><button class="btn btn-primary"><i class="icon-plus"></i>新增</button></a>
        <a href="<?php echo U('article/index'); ?>&order=add_time" style='color:#000;'><button class="btn">按时间（默认）</button></a>
        <a href="<?php echo U('article/index'); ?>&order=sort_order" style='color:#000;'><button class="btn">按权重</button></a>
        <a href="<?php echo U('article/index'); ?>&order=cate_id" style='color:#000;'><button class="btn">按类别</button></a>
        <div class="btn-group">
        </div>
    </div>
    <div class="well">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>标题</th>
                <th>类别</th>
                <th>内容</th>
                <th>权重</th>
                <th>状态</th>
                <th>日期</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
			<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><tr id="article_<?php echo ($data["article_id"]); ?>">
                <td><?php echo ($data["article_id"]); ?></td>
                <!--<td><a href="<?php echo U('article/edit');?>&aid=<?php echo ($data["article_id"]); ?>"><?php echo (msubstr($data["title"],0,8,'utf-8')); ?></a></td>-->
                <td><?php echo (msubstr($data["title"],0,8,'utf-8')); ?></td>
                <td><?php echo ($data["cate"]); ?></td>
                <td><?php echo (msubstr($data["content"],0,15,'utf-8')); ?></td>
                <td><?php echo ($data["sort_order"]); ?></td>
                <td>
					<?php if(($data["if_show"]) == "1"): ?>上线&nbsp;
						<a href="<?php echo U('article/operation'); ?>&aid=<?php echo ($data["article_id"]); ?>&if_show=2"><i class="icon-arrow-down"></i></a>
					<?php else: ?>
						下线&nbsp;
						<a href="<?php echo U('article/operation'); ?>&aid=<?php echo ($data["article_id"]); ?>&if_show=1"><i class="icon-arrow-up"></i></a><?php endif; ?>
				</td>
				<td><?php echo (date('Y-m-d H:i:s',$data["add_time"])); ?></td>
                <td>
                    <a href="<?php echo U('article/edit'); ?>&aid=<?php echo ($data["article_id"]); ?>"><i class="icon-pencil"></i></a>
                </td>
            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>
    </div>
    <div class="pagination">
		<?php echo ($page); ?>
    </div>

</div>


</div>



<footer>
    <hr>

    <p class="pull-right">Powered by <a href="http://corbin.com133.com/" title="小武中国工作室" target="_blank">小武中国工作室</a></p>


    <p>&copy; 2015 <a href="#">老志画室</a></p>
</footer>




<!-- Le javascript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="__PUBLIC__/lib/bootstrap/js/bootstrap.js"></script>













</body>
</html>