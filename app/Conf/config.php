<?php
return array(
	//'配置项'=>'配置值'
	'DB_TYPE'               => 'mysql',     // 数据库类型
	'DB_HOST'               => 'localhost', // 服务器地址,,
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
    'URL_MODEL'             => 0,
    'TMPL_EXCEPTION_FILE'	=> '/404.html',
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
);
?>