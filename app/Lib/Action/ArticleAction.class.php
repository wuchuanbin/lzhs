<?php

/**
 *	文章类
 */
 class ArticleAction extends Action{
	
	public function __construct() {
		
		//检查是否登录，是否有权限
		parent::__construct();
		
	}

	/**
	 *	文章列表
	 *	order 排序方式 add_time时间 / sort_order权重 / cate_id类别 默认 add_time  
	 */
	public function index() {

		$order = empty($_REQUEST['order']) ? 'add_time' : htmlspecialchars($_REQUEST['order']);

		$article = M('article');

		import('ORG.Util.Page');

		$count = $article->count();

		$page = new Page($count, 2, 'order=' . $order);

		$show = $page->show();

		$list = $article->order($order)->limit($page->firstRow . ',' . $page->listRows)->select();

		$this->assign('list', $list);
		$this->assign('page', $show);
		$this->display();
	}
	
	/**
	 *	添加文章
	 */
	public function add() {
		
		if($_POST) {
			
			$article = D('article');

			if(!$article->create()) {
				$this->ajaxReturn('', $article->getError(), -1);
			}

			$data = $_POST;

			load('extend');

			$data['title']      = I('post.title');
			$data['cate_id']    = I('post.cate_id', '', 'intval');
			$data['content']    = I('post.content', '', 'htmlspecialchars');
			$data['sort_order'] = I('post.sort_order', '', 'intval');
			$data['uid_id']     = I('session.uid_id', '', NULL);
			$data['if_show']    = I('post.if_show', '', 'intval');	// 1 上线 2 下线
			$data['add_time']   = time();
			$data['ip']         = get_client_ip();

			$ret = $article->data($data)->add();
	
			if($ret) {
				$this->ajaxReturn(U('Article/index'), '添加成功', 1);
			} else {
				$this->ajaxReturn('', '添加失败', -1);
			}
		} else {
			$this->display();
		}
	}

	/**
	 *	编辑文章
	 */
	public function edit() {
		
		$aid = isset($_GET['aid']) ? intval($_GET['aid']) : NULL;

		if(!$aid) {
			$this->error('编辑失败，文章ID有误');
		}

		$article = D('article');

		$condition = array();
		$condition['id'] = array('eq', $aid);

		$info = $article->where($condition)->find();

		if(!$info) {
			$this->error('编辑失败，文章ID有误');
		}

		if($_POST) {

			if(!$article->create()) {
				$this->ajaxReturn('', $article->getError(), -1);
			}

			$data['title']      = I('post.title');
			$data['cate_id']    = I('post.cate_id', '', 'intval');
			$data['content']    = I('post.content', '', 'htmlspecialchars');
			$data['sort_order'] = I('post.sort_order', '', 'intval');
			$data['uid_id']     = I('session.uid_id', '', NULL);
			$data['if_show']    = I('post.if_show', '', 'intval');	// 1 上线 2 下线

			$ret = $article->where($condition)->save($data);
	
			if($ret) {
				$this->success('编辑成功', U('article/index'));
			} else {
				$this->error('编辑失败');
			}
		}

		$this->assign('info', $info);

		$this->display();
	}

	/**
	 *	操作 if_show = 1 上线 / if_show = 2 下线 
	 */
	public function operation() {
		
		$aid     = isset($_GET['aid'])     ? intval($_GET['aid'])     : NULL;
		$if_show = isset($_GET['if_show']) ? intval($_GET['if_show']) : NULL;

		if(!$aid) {
			$this->ajaxReturn('', '操作失败，文章ID有误', -1);
		}

		if(!$if_show) {
			$this->ajaxReturn('', '操作失败', -1);
		}

		$article = M('article');

		$condition = array();
		$condition['id'] = array('eq', $aid);

		$info = $article->where($condition)->find();

		if(!$info) {
			$this->ajaxReturn('', '操作失败，文章ID有误', -1);
		}

		$data['id_show'] = $if_show;

		$ret = $article->where($condition)->save($data);
	
		if($ret) {
			$this->ajaxReturn('', '操作成功', 1);
		} else {
			$this->ajaxReturn('', '操作失败', -1);
		}

	}

}
?>