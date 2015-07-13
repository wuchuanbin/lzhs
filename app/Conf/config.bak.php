<?php
return array(
	//'配置项'=>'配置值'

	'SHOW_PAGE_TRACE' => false,	//显示页面Trace信息
	'APP_FILE_CASE'   => TRUE,	//是否检查文件的大小写 对windows平台有效
	'DEFAULT_FILTER'  => 'strip_tags,htmlspecialchars',	//默认参数过滤方法
	'DEFAULT_MODULE'  => 'index',	//默认模块名称
	'DEFAULT_ACTION'  => 'index',	//默认模块名称

	'TOKEN_ON' => TRUE,
	'TOKEN_NAME' => '__hash__',
	'TOKEN_TYPE' => 'md5',
	
	'TMPL_ACTION_ERROR'	   => '',	//错误跳转对应的模板文件
	'TMPL_ACTION_SUCCESS'  => '',	//成功跳转对应的模板文件
	'TMPL_EXCEPTION_FILE'  => '/404.html',

	/* URL设置 */
	'URL_CASE_INSENSITIVE' => true,   // 默认false 表示URL区分大小写 true则表示不区分大小写
	'URL_MODEL'            => 0,       // URL访问模式,可选参数0、1、2、3,代表以下四种模式：
	// 0 (普通模式); 1 (PATHINFO 模式); 2 (REWRITE  模式); 3 (兼容模式)  默认为PATHINFO 模式，提供最好的用户体验和SEO支持
	'URL_PATHINFO_DEPR'    => '/',	// PATHINFO模式下，各参数之间的分割符号
	'URL_PATHINFO_FETCH'   => 'ORIG_PATH_INFO,REDIRECT_PATH_INFO,REDIRECT_URL', // 用于兼容判断PATH_INFO 参数的SERVER替代变量列表
	'URL_HTML_SUFFIX'      => '',  // URL伪静态后缀设置
	'URL_PARAMS_BIND'      => true, // URL变量绑定到Action方法参数
	'URL_404_REDIRECT'     =>  '', // 404 跳转页面 部署模式有效


	'THINK_EMAIL' => array(
		'SMTP_Auth'=>true,
		'SMTP_HOST'   => 'smtp.exmail.qq.com', //SMTP服务器
		'SMTP_PORT'   => '465', //SMTP服务器端口
		'SMTP_USER'   => 'admin@wlcyc.com', //SMTP服务器用户名
		'SMTP_PASS'   => 'xx', //SMTP服务器密码
		'FROM_EMAIL'  => 'admin@wlcyc.com', //发件人EMAIL
		'FROM_NAME'   => 'YJL', //发件人名称
		'REPLY_EMAIL' => 'admin@wlcyc.com', //回复EMAIL（留空则为发件人EMAIL）
		'REPLY_NAME'  => 'admin', //回复名称（留空则为发件人名称）
	 ),

	 /* 数据库配置 */
	'DB_TYPE'               => 'mysql',     // 数据库类型
	'DB_HOST'               => 'lzhs.gotoftp3.com', // 服务器地址,,
	'DB_NAME'               => 'lzhs',// 数据库名
	'DB_USER'               => 'lzhs',// 用户名
	'DB_PWD'                => '15002145',// 密码
	'DB_PORT'               => 3306,        // 端口
	'DB_PREFIX'             => '',    // 数据库表前缀
	'DB_SUFFIX'             => '',          // 数据库表后缀
    'DB_FIELDTYPE_CHECK'    => false,       // 是否进行字段类型检查
    'DB_FIELDS_CACHE'       => false,        // 启用字段缓存
    'DB_CHARSET'            => 'utf8',      // 数据库编码默认采用utf8
    'DB_DEPLOY_TYPE'        => 0, // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
    'DB_RW_SEPARATE'        => false,       // 数据库读写是否分离 主从式有效

	/* 模板 */
//	'TMPL_PARSE_STRING' => array(
//		'__JS__' => 'Static/js/',
//		'__CSS__' => 'Static/css/',
//		'__IMAGES__' => 'Static/images/',
//	),
);
?>