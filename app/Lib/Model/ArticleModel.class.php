<?php
	
class ArticleModel extends Model{
	
	protected $_validate = array(
		
		array('title', 'require', '请输入文章标题'),
		array('cate_id', 'require', '请选择文章类别'),
		array('content', 'require', '请输入文章内容'),
	);
}
?>