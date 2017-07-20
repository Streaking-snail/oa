<?php
namespace Home\Controller;
use Common\Common\Controller\AdminBaseController;
class SubCategoryController extends AdminBaseController {
    
	public $locations = array();
	public $category_id;
	
	
	function __construct(){
		parent::__construct();
		$this->locations = array(
				array('is_checked'=>false, 'name'=>'系列管理', 'url'=>U('SubCategory/index'))
		);
		if( isset($_POST['category_id']) ){
			$this->category_id = intval($_POST['category_id']);
	    }else if( isset($_GET['category_id']) ){
			$this->category_id = intval($_GET['category_id']);
		}else{
			$this->category_id = 0;
		}
		if( intval($this->category_id)>=0 ){
			$_SESSION['category_id'] = $this->category_id; 
		}else{
			$this->category_id = !empty($_SESSION['category_id'])?intval($_SESSION['category_id']):0;
		}
		$category = M('category')->where("id=%d", array($this->category_id))->find();
		if( $category ){
			$loc_name_1 = $category['name'];
		}else{
			$loc_name_1 = "产品系列";
		}
		$this->assign('loc_name_1', $loc_name_1);
		$this->assign('locations', $this->locations);
	}
	
	public function index(){
		$this->assign("loc_name_2", "产品系列");
		$search_info['key'] = isset($_POST['key'])?$_POST['key']:"";
		$search_info['category_id'] = $this->category_id;
		$search_info['num'] = isset($_POST['num'])?intval($_POST['num']):isset($_GET['num'])?intval($_GET['num']):10;
		$this->assign('search_info', $search_info);
		$SubCategory = D('SubCategory');
		$res = $SubCategory->search_info($search_info);
		$this->assign('SubCategory', $SubCategory);
		$this->assign('sub_categories', $res['sub_categories']);
		$this->assign('show_page', $res['show_page']);
		$s_categories = D('Category')->get_category_options();
		$this->assign('s_categories', $s_categories);
		$this->display();
	}
    
    public function add_info(){
    	$this->assign("loc_name_2", "添加");
    	$categories = M('category')->where("is_del=0")->select();
    	$this->assign('categories', $categories);
    	$this->assign('sub_category', array('category_id'=>$this->category_id));
    	$this->display();
    }
    
    public function create_info(){
    	if( isset($_POST['sub_category']) ){
    		$_POST['sub_category']['admin_user_id'] = $this->admin_user_id;
    		$res = D('SubCategory')->create_info($_POST['sub_category']);
    		$notice = $res['notice'];
    		if( $res['status'] ){
    			$this->set_notice(1, $notice);
    			$this->redirect("SubCategory/index");
    		}
    	}else{
    		$notice = "参数错误";
    	}
    	$this->set_notice(2, $notice);
    	$this->redirect('SubCategory/add_info');
    }
    
    public function edit(){
    	$this->assign("loc_name_2", "修改");
    	$sub_category = M('sub_category')->where("id=%d", array($_GET['id']))->find();
    	$this->assign('sub_category', $sub_category);
    	$this->display();
    }
    
    public function update_info(){
    	if( isset($_POST['sub_category']) ){
    		$res = D('SubCategory')->update_info($_POST['sub_category']);
    		$notice = $res['notice'];
    		if( $res['status'] ){
    			$this->set_notice(1, $notice);
    			$this->redirect("SubCategory/index");
    		}
    	}else{
    		$notice = "参数错误";
    	}
    	$this->set_notice(2, $notice);
    	$this->redirect('SubCategory/edit', array('id'=>$_POST['sub_category']['id']));
    }
    
    public function delete_item(){
    	$f = M('sub_category')->where("id=%d", array($_GET['id']))->setField(array('is_del'=>1));
    	if( $f!==false ){
    		$this->set_notice(1, "删除成功");
    	}else{
    		$this->set_notice(2, "删除出错，请重试");
    	}
    	$this->redirect("SubCategory/index");
    }
    
}