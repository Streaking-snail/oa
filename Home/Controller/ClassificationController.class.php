<?php
namespace Home\Controller;
use Common\Common\Controller\AdminBaseController;
class ClassificationController extends AdminBaseController {
    
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
		$this->assign("loc_name_2", "类别列表");
		$search_info['key'] = isset($_POST['key'])?$_POST['key']:"";
		$search_info['category_id'] = $this->category_id;
		$search_info['num'] = isset($_POST['num'])?intval($_POST['num']):isset($_GET['num'])?intval($_GET['num']):10;
		$this->assign('search_info', $search_info);
		$SubCategories = D('Classification');
		$res = $SubCategories->search_info($search_info);
// 		$this->assign('SubCategory', $SubCategories);
//                echo $SubCategories->getLastSql();exit;
//                var_dump($res['classifications']);die;
                //var_dump($res['sub_categories']);die;
		$this->assign('classifications', $res['classifications']);
		$this->assign('show_page', $res['show_page']);
		$s_categories = D('SubCategory')->get_category_options();
		$this->assign('s_categories', $s_categories);
		$this->display();
	}
    
    public function add_info(){
    	$this->assign("loc_name_2", "添加");
    	$categories = D('Category')->get_category_options();
        //var_dump($categories);die;
    	$this->assign("categories", $categories);
    	$this->assign("sub_categories", array(array('id'=>0, "name"=>"请选择系列")));
    	$this->display();
    }
    
    public function create_info(){
    	if( isset($_POST['classification']) ){
    		$res = D('Classification')->create_info($_POST['classification']);
    		$notice = $res['msg'];
    		if( $res['status'] ){
    			$this->set_notice(1, $notice);
    			$this->redirect("Classification/index");
    		}
    	}else{
    		$notice = "参数错误";
    	}
    	$this->set_notice(2, $notice);
    	$this->redirect('Classification/add_info');
    }
    
    public function edit(){
    	$this->assign("loc_name_2", "修改");
    	$classification = M('classification')->where("id=%d", array($_GET['id']))->find();
    	
    	$sub_category = M('sub_category')->where("id=%d", array($classification['sub_category_id']))->find();
    	$classification['category_id'] = $sub_category['category_id'];
    	$categories = D('Category')->get_category_options();
    	$this->assign('categories', $categories);
    	$sub_categories = M('sub_category')->where("category_id=%d", array($sub_category['category_id']))->select();
    	$this->assign('sub_categories', $sub_categories);
    	$this->assign('classification', $classification);
    	$this->display();
    }
    
    public function update_info(){
    	if( isset($_POST['classification']) ){
    		$res = D('Classification')->update_info($_POST['classification']);
    		$notice = $res['notice'];
    		if( $res['status'] ){
    			$this->set_notice(1, $notice);
    			$this->redirect("Classification/index");
    		}
    	}else{
    		$notice = "参数错误";
    	}
    	$this->set_notice(2, $notice);
    	$this->redirect('Classification/edit', array('id'=>$_POST['classification']['id']));
    }
    
    public function delete_item(){
    	$f = M('Classification')->where("id=%d", array($_GET['id']))->setField(array('is_del'=>1));
    	if( $f!==false ){
    		$this->set_notice(1, "删除成功");
    	}else{
    		$this->set_notice(2, "删除出错，请重试");
    	}
    	$this->redirect("Classification/index");
    }
    
}