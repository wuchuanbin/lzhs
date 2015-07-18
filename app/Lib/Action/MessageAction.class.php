<?php

/**
 *	消息类
 */
 class MessageAction extends Action{
	
	public function __construct() {
		
		//检查是否登录，是否有权限
		parent::__construct();
		
	}

	/**
	 *	消息列表
	 *	order 排序方式 add_time时间 / sort_order权重 / cate_id班级类别 默认 add_time  
	 */
	public function index() {

		$order = empty($_REQUEST['order']) ? 'add_time' : htmlspecialchars($_REQUEST['order']);

		$class_msg = M('class_msg');

		import('ORG.Util.Page');

		$count = $class_msg->count();

		$page = new Page($count, 2, 'order=' . $order);

		$show = $page->show();

		$list = $class_msg->order($order . ' desc')->limit($page->firstRow . ',' . $page->listRows)->select();
		
		$user = M('users');
		$cate = M('class_msg_cate');

		foreach($list as $key => $val) {
			$username = $user->field('user_name')->where('uid=' . $val['uid_id'])->find();
			$catename     = $cate->field('cate_name')->where('cate_id=' . $val['cate_id'])->find();
			$list[$key]['username'] = $username['user_name'];
			$list[$key]['cate']     = $catename['cate_name'];
		}

		$this->assign('list', $list);
		$this->assign('page', $show);
		$this->display();
	}

	/**
	 *	根据教师对应班级获取消息列表
	 */
	public function classMsgList() {
		
		$_SESSION['userInfo']['class_id1'] = 28;
		$_SESSION['userInfo']['class_id2'] = 29;

		$class_id1 = $_SESSION['userInfo']['class_id1'];
		$class_id2 = $_SESSION['userInfo']['class_id2'];

		$cid = isset($_REQUEST['cid']) ? intval($_REQUEST['cid']) : $class_id1;

		if(!$cid) {
			$this->assign('title', '查看失败');
			$this->assign('message', '班级ID有误');
			$this->error();
		}

		$class_msg_cate = M('class_msg_cate');
		$class_msg = M('class_msg');

		$class_name = array();
		
		if($class_id1) {
			$class_name[] = $class_msg_cate->where('cate_id=' . $class_id1)->find();
		}

		if($class_id2) {
			$class_name[] = $class_msg_cate->where('cate_id=' . $class_id2)->find();
		}
		

		$condition = array();
		$condition['cate_id'] = array('eq', $cid);
		$condition['if_show'] = array('eq', '1');

		$class_msg_list = $class_msg->where($condition)->select();

		$article = M('article');

		$article_list = $article->where('if_show=1')->order('sort_order')->limit(5)->select();
	
		$this->assign('article_list', $article_list);

		$this->assign('class_name', $class_name);

		$this->assign('class_msg_list', $class_msg_list);

		$this->display();
	}

	/**
	 *	查看单条消息
	 */
	public function detail() {
		
		$mid = isset($_REQUEST['mid']) ? intval($_REQUEST['mid']) : NULL;

		if(!$mid) {
			$this->assign('title', '查看失败');
			$this->assign('message', '消息ID有误');
			$this->error();
		}

		$class_msg = M('class_msg');

		$condition = array();
		$condition['msg_id'] = array('eq', $mid);

		$info = $class_msg->where($condition)->find();

		if(!$info) {
			$this->assign('title', '查看失败');
			$this->assign('message', '消息ID有误');
			$this->error();
		}

		$article = M('article');

		$list = $article->where('if_show=1')->order('sort_order')->limit(5)->select();
	
		$this->assign('list', $list);

		$this->assign('info', $info);

		$this->display();
	}
	
	/**
	 *	添加消息
	 */
	public function add() {
		
		if($_POST) {
			
			$class_msg = M('class_msg');

			$data = $_POST;

			$data['title']      = I('post.title');
			$data['cate_id']    = I('post.cate_id', '', 'intval');
			$data['content']    = I('post.content', '', 'htmlspecialchars');
			$data['sort_order'] = I('post.sort_order', 1);	//权重默认为 1
			$data['uid_id']     = I('session.uid', '', null);
			$data['if_show']    = I('post.if_show', 1);	// 1 通过 2 删除
			$data['add_time']   = time();
			$data['ip']         = get_client_ip();

			$ret = $class_msg->data($data)->add();
	
			if($ret) {
				$this->ajaxReturn(U('message/index'), '新增成功', 1);
			} else {
				$this->ajaxReturn('', '新增失败', -1);
			}
		} else {
			$cate = M('class_msg_cate');

			$list = $cate->select();

			$this->assign('cate_list', $list);
			$this->display();
		}
	}

	/**
	 *	编辑消息
	 */
	public function edit() {
		
		$mid = isset($_REQUEST['mid']) ? intval($_REQUEST['mid']) : NULL;

		if(!$mid) {
			$this->assign('title', '编辑失败');
			$this->assign('message', '消息ID有误');
			$this->error();
		}

		$class_msg = M('class_msg');

		$condition = array();
		$condition['msg_id'] = array('eq', $mid);

		$info = $class_msg->where($condition)->find();

		if(!$info) {
			$this->assign('title', '编辑失败');
			$this->assign('message', '消息ID有误');
			$this->error();
		}

		$cate = M('class_msg_cate');

		$list = $cate->select();

		$this->assign('cate_list', $list);

		if($_POST) {

//			if(!$class_msg->create()) {
//				$this->assign('title', '编辑失败');
//				$this->assign('message', $class_msg->getError());
//				$this->error();
//			}

			$data['title']      = I('post.title');
			$data['cate_id']    = I('post.cate_id', '', 'intval');
			$data['content']    = I('post.content', '', 'htmlspecialchars');
			$data['sort_order'] = I('post.sort_order');	//权重默认为 1
			$data['if_show']    = I('post.if_show');	// 1 上线 2 下线

			$ret = $class_msg->where($condition)->save($data);
	
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

		$this->display();
	}

	/**
	 *	操作 if_show = 1 通过 / if_show = 2 删除 
	 */
	public function operation() {
		
		$mid     = isset($_GET['mid'])     ? intval($_GET['mid'])     : NULL;
		$if_show = isset($_GET['if_show']) ? intval($_GET['if_show']) : NULL;

		if(!$mid) {
			$this->assign('title', '操作失败');
			$this->assign('message', '消息ID有误');
			$this->error();
		}

		if(!$if_show) {
			$this->assign('title', '操作失败');
			$this->assign('message', '请求失败，请重试');
			$this->error();
		}

		$class_msg = M('class_msg');

		$condition = array();
		$condition['msg_id'] = array('eq', $mid);

		$info = $class_msg->where($condition)->find();

		if(!$info) {
			$this->assign('title', '操作失败');
			$this->assign('message', '消息ID有误');
			$this->error();
		}

		$data['if_show'] = $if_show;

		$ret = $class_msg->where($condition)->save($data);
	
		if($ret) {
			$this->assign('title', '操作成功');
			$this->success();
		} else {
			$this->assign('title', '操作失败');
			$this->assign('message', '请求失败，请重试');
			$this->error();
		}

	}  

}
?>