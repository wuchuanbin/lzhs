<?php
	
class ArticleModel extends Model{
	
	protected $_validate = array(
		
		array('title', 'require', '请输入消息标题'),
		array('cate_id', 'require', '请选择班级'),
		array('content', 'require', '请输入消息内容'),
	);
}
?>