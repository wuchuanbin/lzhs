<?php

/**
 *	班级 / 文章 分类
 */
class CateAction extends Action{

	
	public $table = '';
	public $title = '';
	public $flag  = '';

	public function __construct() {
		
		parent::__construct();

		$this->flag = htmlspecialchars($_REQUEST['flag']);
		
		if($this->flag == 'article') {
			$this->table = 'article_cate';
			$this->title = '文章分类';
		} else {
			$this->table = 'class_msg_cate';
			$this->title = '班级';
		}
	}

	/**
	 *	班级/文章 分类列表
	 *	param string flag = class(班级) / article(文章)
	 */
	public function index() {

		$cate = M($this->table);

		import('ORG.Util.Page');

		$count = $cate->count();

		$page = new Page($count, 20);

		$show = $page->show();

		$list = $cate->limit($page->firstRow . ',' . $page->listRows)->select();
		
		$this->assign('list', $list);
		$this->assign('page', $show);
		$this->assign('title', $this->title);
		$this->assign('flag', $this->flag);
		$this->display();
	}

	/**
	 *	添加
	 */
	public function add() {

		if($_POST) {
			
			$cate = M($this->table);

			$data = $_POST;

			$data['cate_name']  = I('post.cate_name');
			$data['sort_order'] = I('post.sort_order', 1);
			$data['parent_id']  = 0;

			if(!$data['cate_name']) {
				$this->ajaxReturn('', '值不得为空', -1);
			}

			$ret = $cate->data($data)->add();
	
			if($ret) {
				$this->ajaxReturn(U('cate/index?flag=' . $this->flag), '新增成功', 1);
			} else {
				$this->ajaxReturn('', '新增失败', -1);
			}
		}

		$this->assign('title', $this->title);
		$this->assign('flag', $this->flag);
		$this->display();
	}

	/**
	 *	编辑
	 */
	public function edit() {
		
		$cid = isset($_REQUEST['cid']) ? intval($_REQUEST['cid']) : NULL;

		if(!$cid) {
			$this->assign('title', '编辑失败');
			$this->assign('message', '参数ID有误');
			$this->error();
		}

		$cate = M($this->table);

		$condition = array();
		$condition['cate_id'] = array('eq', $cid);

		$info = $cate->where($condition)->find();

		if(!$info) {
			$this->assign('title', '编辑失败');
			$this->assign('message', '参数ID有误');
			$this->error();
		}

		if($_POST) {

			$data['cate_name']  = I('post.cate_name');
			$data['sort_order'] = I('post.sort_order');

			if(!$data['cate_name']) {
				$this->ajaxReturn('', '值不得为空', -1);
			}

			$ret = $cate->where($condition)->save($data);
	
			if($ret) {
				$this->assign('title', '编辑成功');
				$this->success();
			} else {
				$this->assign('title', '编辑失败');
				$this->assign('message', '请求失败，请重试');
				$this->error();
			}
		}

		$this->assign('info', $info);
		$this->assign('title', $this->title);
		$this->assign('flag', $this->flag);

		$this->display();
	}

	/**
	 *	删除 
	 */
	public function del() {
		
		$cid = isset($_REQUEST['cid']) ? intval($_REQUEST['cid'])     : NULL;

		if(!$cid) {
			$this->ajaxReturn('', '参数ID有误', -1);
		}

		$cate = M($this->table);

		$condition = array();
		$condition['cate_id'] = array('eq', $cid);

		$info = $cate->where($condition)->find();

		if(!$info) {
			$this->ajaxReturn('', '参数ID有误', -1);
		}

		$ret = $cate->where($condition)->delete();
	
		if($ret) {
			$this->ajaxReturn('', '删除成功', 1);
		} else {
			$this->ajaxReturn('', '删除失败', -1);
		}

	}	

}
?>