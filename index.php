<?php
header('content-type:text/html;charset=utf-8');
// ����ThinkPHP���·��

define('THINK_PATH', './ThinkPHP/');

//������Ŀ��ƺ�·��

define('APP_NAME', 'lzhs');
define('APP_DEBUG', true);

define('APP_PATH', './app/');

// ���ؿ������ļ� 

require(THINK_PATH."/ThinkPHP.php");
Vendor("session");
//ʵ��һ����վӦ��ʵ��

//App::run();

?>




