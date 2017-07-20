<?php
namespace Home\Controller;
use Common\Common\Controller\AdminBaseController;
class DoExplosionController extends AdminBaseController {
    
	public $locations = array();
	public $category_id,$sub_category_id, $classification_id;
	
	function __construct(){
		parent::__construct();
		$this->locations = array(
				array('is_checked'=>false, 'name'=>'办事处电商爆款申请', 'url'=>U('DoExplosion/index'))
		);
        $this->assign('loc_name_1', "办事处电商爆款申请");
		$this->assign('locations', $this->locations);
	}
	
	public function index(){
		$this->assign("loc_name_2", "办事处电商爆款申请列表");
		$search_info['key'] = isset($_POST['key'])?$_POST['key']:'';
		$search_info['num'] = isset($_POST['num'])?intval($_POST['num']):(isset($_GET['num'])?intval($_GET['num']):10);
        $search_info['deport'] = isset($_POST['deport'])?$_POST['deport'] : '';
        $search_info['admin_user'] = isset($_POST['admin_user'])?$_POST['admin_user'] : '';
        $search_info['time1'] = isset($_POST['time1'])?intval(strtotime($_POST['time1'])):'';
        $search_info['time2'] = isset($_POST['time2'])?intval(strtotime($_POST['time2'])):'';
        $search_info['show'] = isset($_POST['show'])?intval($_POST['show']):'0';
		$this->assign('search_info', $search_info);
		$DoExplosion = D('DoExplosion');
		$res = $DoExplosion->search_info($search_info);
		$this->assign('do_explosion', $res['data']);
		$this->assign('show_page', $res['show_page']);
		if( $this->user_info['is_admin']==1 || $this->user_info['id']==1 ){
			$this->assign('application', 1);
		}
        $this->assign('number_per_page',$search_info['num']); 
        $this->assign('page_number',$res['now_page']);
        $this->assign('total_count',count($res['count']));
    	$this->display();
    }
    

    public function add_info(){
    	$this->assign("loc_name_2", "添加");
        $this->assign('explosion', array('no'=>time().rand(10,99)));
    	$products = D('Product')->get_products_list();
    	$this->assign("products", $products);
    	$this->display();
    }
    
    public function create_info(){
    	if( isset($_POST['explosion']) ){
    		$_POST['explosion']['admin_user_id'] = $this->admin_user_id;
            $res = D('DoExplosion')->create_info($_POST['explosion']);
    		$notice = $res['msg'];
    		if( $res['status'] ){
    			$this->set_notice(1, $notice);
    			$this->redirect("DoExplosion/index");
                exit;
    		}else{
                $this->set_notice(2, $notice);
				$products = D('Product')->get_products_list();
				$this->assign("products", $products);
    			$this->assign('explosion', $_POST['explosion']);
                $this->display("add_info");
                exit;
    		}
    	}else{
    		$notice = "参数错误";
    	}
    	$this->set_notice(2, $notice);
    	$this->redirect('Product/add_info');
    }
    
    public function edit(){
    	$this->assign("loc_name_2", "修改");
    	$explosion = M('do_explosions')->where("id=%d", array($_GET['id']))->find();
		$explosion_items = M('do_explosion_items')->field('a.*,b.number,c.`name`')->alias('a')->join('LEFT JOIN '.C('DB_PREFIX').'products b on a.product_id = b.id '
			.' left join '.C('DB_PREFIX').'category c on b.category_id = c.id')
			->where('do_explosion_id=%d',array($_GET['id']))->select();
		$products = D('Product')->get_products_list();
		$this->assign('id',intval($_GET['id']));
		$this->assign('products',$products);
		$this->assign('explosion_items',$explosion_items);
		$this->assign("explosion", $explosion);
    	$this->display();
    }
    
    public function update_info(){
    	if( isset($_POST['explosion']) ){
			$_POST['explosion']['admin_user_id'] = $this->admin_user_id;
			$res = D('DoExplosion')->update_info($_POST['explosion']);
    		$notice = $res['msg'];
    		if( $res['status'] ){
    			$this->set_notice(1, $notice);
    			$this->redirect("DoExplosion/index");
    		}
    	}else{
    		$notice = "参数错误";
    	}
    	$this->set_notice(2, $notice);
    	$this->redirect('DoExplosion/edit');
    }
    
    public function del(){
    	$f = M('do_explosions')->where("id=%d", array(intval($_GET['id'])))->setField(array('is_del'=>1));
    	if( $f!==false ){
    		$this->set_notice(1, "删除成功");
    	}else{
    		$this->set_notice(2, "删除出错，请重试");
    	}
    	$this->redirect("DoExplosion/index");
    }

	public function detail(){
		$this->assign('is_print', 1);
		$this->assign("loc_name_2", "详情");
		if(isset($_GET['id'])){
			$explosion = M('do_explosions')->where("id=%d", array($_GET['id']))->find();
			$explosion_items = M('do_explosion_items')->field('a.*,b.number,c.`name`')->alias('a')->join('LEFT JOIN '.C('DB_PREFIX').'products b on a.product_id = b.id '
				.' left join '.C('DB_PREFIX').'category c on b.category_id = c.id')
				->where('do_explosion_id=%d',array($_GET['id']))->select();
			$products = D('Product')->get_products_list();
			$this->assign('id',intval($_GET['id']));
			$this->assign('products',$products);
			$this->assign('explosion_items',$explosion_items);
			$this->assign("explosion", $explosion);
			layout('layouts/detail');
			$this->display();
		}else{
			$this->set_notice(2, "参数有误");
			$this->redirect("DoExplosion/index");
		}

	}


	/**
	 * 前台选择产品JS请求返回大类跟货号
	 */
	public function get_products_info(){
		$id = intval($_REQUEST['id']);
		$item_info = M('products')->alias('a')->field('a.number,b.`name`')
			->join('LEFT JOIN '.C('DB_PREFIX').'category b on a.category_id = b.id')->find();
		echo json_encode($item_info);
	}

	public function get_checked_list()
	{
		layout(false);
		header("Content-type: text/html; charset=utf-8");
		$data_status = M('do_explosion_status')->alias("a")->join("left join " . C("DB_PREFIX") . "admin_user b on b.id=a.admin_user_id")
			->field("a.*, ifnull(b.name, b.username) as username")
			->where("a.do_explosion_id=%d", array($_GET['id']))->order("a.create_time asc")->select();
		$this->assign('data_status', $data_status);
		$this->display("DoExplosion/_checked_list");
		exit;
	}

	//审核
	public function check()
	{
		if (isset($_POST['check_id'])) {
			if (isset($_POST['type'])) {
				$status = $_POST['type'] == 'checked' ? 1 : 2;
			} else {
				$status = 1;
			}
			$controller = strtolower(CONTROLLER_NAME);
			if (isset($_FILES['file']) && !empty($_FILES['file']['name'])) {
				include_once SITE_PATH . '/Home/Model/FileUpload.class.php';
				$FileUpload = new \FileUpload();
				$path = $FileUpload->save_file($_FILES['file'], "/uploadfiles/$controller/" . date('Y-m-d') . "/");
			}
			$f = M('do_explosion_status')->add(array("do_explosion_id" => $_POST['check_id'],
				"content" => $_POST['content'], 'create_time' => time(),
				"admin_user_id" => $_SESSION['admin_user_id'], "status" => $status,
				"url_path" => isset($path)?$path:'', 'name' => trim($_POST['attach_name'])
			));
			if ($f !== false) {
				$this->set_notice(1, "审核操作成功");
			} else {
				$this->set_notice(2, '审核操作失败,请重试');
			}
		} else {
			$this->set_notice(2, "参数错误");
		}
		$this->redirect("index");
	}
}