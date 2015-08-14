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
    <h1 class="page-title">作业列表</h1>
    <div class="btn-toolbar">
        <button class="btn btn-primary"><i class="icon-plus"></i> <a href="/index.php?m=Manager&a=workExec" >新增</a></button>

        <div class="btn-group">
        </div>
    </div>
    <div class="well">
        <table class="table">
            <thead>
            <tr>

                <th>作业编号</th>
                <th>作业名称</th>
                <th>已经上传的作品</th>
                <!--<th>对应班级</th>-->
                <th>老师</th>
                <th>发布时间</th>


            </tr>
            </thead>
            <tbody>
            <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><tr id='w_<?php echo ($data["id"]); ?>'>

                <td><?php echo ($data["id"]); ?></td>
                <td><?php echo ($data["name"]); ?></td>
                <td><?php echo ($data["count"]); ?>个</td>

                <!--<td><?php echo ($data["class_id"]); ?></td>-->
                <td><?php echo ($data["tid"]); ?></td>
                <td><?php echo (date('Y-m-d H:i:s',$data["create_time"])); ?></td>

                <td>
                    <a href="/index.php?m=Manager&a=dianPing&id=<?php echo ($data["id"]); ?>">点评作业</a>
                    <a href="/index.php?m=Manager&a=workExec&id=<?php echo ($data["id"]); ?>"><i class="icon-pencil"></i></a>
                    <a href="javascript:;" onclick="delwork(<?php echo ($data["id"]); ?>)"><i class="icon-remove"></i></a>
					<input type='hidden' id='delurl' value="<?php echo U('manager/delWork'); ?>" />
                </td>
            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>
    </div>
    <!--<div class="pagination">-->
        <!--<ul>-->
            <!--<li><a href="#">Prev</a></li>-->
            <!--<li><a href="#">1</a></li>-->
            <!--<li><a href="#">2</a></li>-->
            <!--<li><a href="#">3</a></li>-->
            <!--<li><a href="#">4</a></li>-->
            <!--<li><a href="#">Next</a></li>-->
        <!--</ul>-->
    <!--</div>-->
    <?php echo ($page); ?>

    <div class="modal small hide fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">Delete Confirmation</h3>
        </div>
        <div class="modal-body">
            <p class="error-text"><i class="icon-warning-sign modal-icon"></i>Are you sure you want to delete the user?</p>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
            <button class="btn btn-danger" data-dismiss="modal">Delete</button>
        </div>
    </div>

</div>
<script>
	function delwork(wid) {
		
		if(wid) {
			var url = $('#delurl').val();
			$.ajax({
				url:url,
				type:'post',
				dataType:'json',
				data:{
					'wid':wid,
				},
				success:function(msg){
					if(msg.status == 1) {
						$('#w_' + wid).remove();
					}
					alert(msg.info);
					return false;
				}
			});
		}
	}
</script>


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