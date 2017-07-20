<?php
namespace Home\Controller;
use Common\Common\Controller\AdminBaseController;
class CategoryController extends AdminBaseController {
    
	public $locations = array();
	public $ptype_id;
	
	
	function __construct(){
		parent::__construct();
		$this->locations = array(
				array('is_checked'=>false, 'name'=>'大类管理', 'url'=>U('Category/index'))
		);
		$this->assign('loc_name_1', "大类管理");
		$this->assign('locations', $this->locations);
	}
	
	public function index(){
		$this->assign("loc_name_2", "大类列表");
		$search_info['key'] = isset($_POST['key'])?$_POST['key']:'';
		$search_info['num'] = isset($_POST['num'])?intval($_POST['num']):isset($_GET['num'])?intval($_GET['num']):10;
		$this->assign('search_info', $search_info);
		$res = D('Category')->search_info($search_info);
		$this->assign('categories', $res['categories']);
		$this->assign('r_items', $res['items']);
		$this->assign('show_page', $res['show_page']);
		$col_status = M('ptype_status')->where("ptype_id=%d",array($search_info['ptype_id']))->field("id as val,name")->select();
		$this->assign('s_status', $col_status);
                $this->display();
    }
    
    public function add_info(){
    	$this->assign("loc_name_2", "添加");
    	$this->display();
    }
    
    public function create_info(){
    	if( isset($_POST['category']) ){
    		$_POST['category']['admin_user_id'] = $this->admin_user_id;
    		$res = D('Category')->create_info($_POST['category']);
    		$notice = $res['notice'];
    		if( $res['status'] ){
    			$this->set_notice(1, $notice);
    			$this->redirect("Category/index");
    		}
    	}else{
    		$notice = "参数错误";
    	}
    	$this->set_notice(2, $notice);
    	$this->redirect('Category/add_info');
    }
    
    public function edit(){
    	$this->assign("loc_name_2", "修改");
    	$category = M('category')->where("id=%d", array($_GET['id']))->find();
    	$this->assign("category", $category);
    	$this->display();
    }
    
    public function update_info(){
    	if( isset($_POST['category']) ){
    		$_POST['category']['admin_user_id'] = $this->admin_user_id;
    		$res = D('Category')->update_info($_POST['category']);
    		$notice = $res['notice'];
    		if( $res['status'] ){
    			$this->set_notice(1, $notice);
    			$this->redirect("Category/index");
    		}
    	}else{
    		$notice = "参数错误";
    	}
    	$this->set_notice(2, $notice);
    	$this->redirect('Category/edit', array('id'=>$_POST['category']['id']));
    }
    
    public function del(){
    	$f = M('category')->where("id=%d", array($_GET['id']))->setField(array('is_del'=>1));
    	if( $f!==false ){
    		$this->set_notice(1, "删除成功");
    	}else{
    		$this->set_notice(2, "删除出错，请重试");
    	}
    	$this->redirect("Category/index");
    }
    
    public function upload_file(){
    	include_once SITE_PATH.'/Home/Model/FileUpload.class.php';
    	$FileUpload = new \FileUpload();
    	$path = $FileUpload->save_file($_POST['pname'], "/uploadfiles/products/".date('Y-m-d')."/");
    	if( $id>0 ){
    		echo "yes";
    	}else{
    		echo "no";
    	}
    	exit;
    }
    
}