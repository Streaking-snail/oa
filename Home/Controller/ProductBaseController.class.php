<?php
namespace Home\Controller;
use Common\Common\Controller\AdminBaseController;
class ProductBaseController extends AdminBaseController {
    
	public $locations = array();
	public $category_id, $sub_category_id, $classification_id;
	
	function __construct(){
		parent::__construct();
		$this->locations = array(
				array('is_checked'=>false, 'name'=>'产品价格', 'url'=>U('ProductBase/index'))
		);
        $this->category_id = isset($_POST['category_id'])?intval($_POST['category_id']):(isset($_GET['category_id'])?$_GET['category_id']:0);
        $this->sub_category_id = isset($_POST['sub_category_id'])?intval($_POST['sub_category_id']):(isset($_GET['sub_category_id'])?$_GET['sub_category_id']:0);
        $this->classification_id = isset($_POST['classification_id'])?intval($_POST['classification_id']):(isset($_GET['classification_id'])?$_GET['classification_id']:0);
        $this->assign('loc_name_1', "产品价格");
		$this->assign('locations', $this->locations);
	}
	
	public function index(){
		$this->assign("loc_name_2", "产品价格列表");
		$search_info['key'] = isset($_POST['key'])?$_POST['key']:'';
		$search_info['category_id'] = $this->category_id;
		$search_info['sub_category_id'] = $this->sub_category_id;
		$search_info['classification_id'] = $this->classification_id;
		$search_info['num'] = isset($_POST['num'])?intval($_POST['num']):(isset($_GET['num'])?intval($_GET['num']):10);
                $search_info['code'] = isset($_POST['code'])?$_POST['code']:'';
                $search_info['number'] = isset($_POST['number'])?$_POST['number']:'';
                $search_info['name'] = isset($_POST['name'])?$_POST['name']:'';
                $search_info['price'] = isset($_POST['price'])?$_POST['price']:'';
                $search_info['price1'] = isset($_POST['price1'])?intval($_POST['price1']):'';
                $search_info['price2'] = isset($_POST['price2'])?intval($_POST['price2']):'';
                $search_info['sort'] = isset($_POST['sort'])?$_POST['sort']:'';
                $search_info['show'] = isset($_POST['show'])?intval($_POST['show']):'0';
		$this->assign('search_info', $search_info);
		$res = D('ProductBase')->search_info($search_info);
		$this->assign('is_number', 1);
		$this->assign('product_bases', $res['product_bases']);
		$s_categories = D('Category')->get_category_options();
		$this->assign('s_categories', $s_categories);
		$sort_arrs = array(
                    array("default","默认"),
                    array("now_price_up","现价升序"),
                    array("now_price_down","现价降序"),
                    array("ty_price_up","统一售价升序"),
                    array("ty_price_down","统一售价降序"),
                    array("min_price_up","最低售价升序"),
                    array("min_price_down","最低售价降序"),
                );
		if( !empty($this->category_id) ){
			$s_sub_categories = M('sub_category')->where("category_id=%d and is_del=0 ", array($this->category_id))->select();
			array_unshift($s_sub_categories, array('name'=>'请选择', 'id'=>0));
		}else{
			$s_sub_categories = array(array("id"=>0, "name"=>"请选择"));
		}
		$this->assign('s_sub_categories', $s_sub_categories);
		
		if( !empty($this->sub_category_id) ){
			$s_classifications = M('classification')->where("sub_category_id=%d and is_del=0", array($this->sub_category_id))->select();
			array_unshift($s_classifications, array('name'=>'请选择', 'id'=>0));
		}else{
			$s_classifications = array(array("id"=>0, "name"=>"请选择"));
		}
		$this->assign('s_classifications', $s_classifications);
		
		$this->assign('show_page', $res['show_page']);
		$total_count = M('products')->select();
		$this->assign('s_status', $col_status);
                $this->assign('sort_arrs', $sort_arrs);
        $this->assign('number_per_page',$search_info['num']);
        $this->assign('page_number',$res['now_page']);
        $this->assign('total_count',count($total_count));
        $this->assign('is_export', 1);
        $this->assign('is_more_search', 1);
        $this->assign('is_price', 1);
    	$this->display();
    }
    
    public function add_info(){
    	$this->assign("loc_name_2", "添加");
    	$categories = D('Category')->get_category_options();
    	$this->assign("categories", $categories);
    	$this->assign("sub_categories", array(array('id'=>0, "name"=>"请选择系列")));
    	$this->assign("classifications", array(array('id'=>0, "name"=>"请选择类别")));
    	$this->assign('product', array('category_id'=>$this->category_id, 'sub_category_id'=>$this->sub_category_id, 'classification_id'=>$this->classification_id));
    	$this->display();
    }
    
    public function create_info(){
    	if( isset($_POST['product_base']) ){
            $_POST['product_base']['file']=$_FILES['file'];
            $res = D('ProductBase')->create_info($_POST['product_base']);
    		$notice = $res['msg'];
    		if( $res['status'] ){
    			$this->set_notice(1, $notice);
                $this->assign("categories", $categories);
                $this->assign("sub_categories", $sub_categories);
                $this->assign("product", array('sub_category_id'=>$_POST['product_base']['sub_category_id']));
    			$this->assign('product_base', $_POST['product_base']);
    			$this->redirect("ProductBase/index");
                $this->display("add_info");
                exit;
    		}else{
                $this->set_notice(2, $notice);
    			$categories = D('Category')->get_category_options();
    			$this->assign("categories", $categories);
    			$sub_categories = M('sub_category')->where("category_id=%d", array($_POST['product_base']['category_id']))->select();
    			$this->assign("sub_categories", $sub_categories);
    			$classifications = M('classification')->where("sub_category_id=%d", array($_POST['product_base']['sub_category_id']))->select();
    			$this->assign("classifications", $classifications);
    			$this->assign('product_base', $_POST['product_base']);
                $this->display("add_info");
                exit;
    		}
    	}else{
    		$notice = "参数错误";
    	}
    	$this->set_notice(2, $notice);
    	$this->redirect('ProductBase/add_info');
    }
    
    public function edit(){
    	$this->assign("loc_name_2", "修改");
    	$product_base = M('product_base')->where("id=%d", array($_GET['id']))->find();
    	$this->assign("product", array('sub_category_id'=>$product_base['sub_category_id']));
    	$this->assign("product_base", $product_base);
    	$categories = D('Category')->get_category_options();
    	$this->assign("categories", $categories);
    	$sub_categories = M('sub_category')->where("category_id=%d", array($product_base['category_id']))->select();
    	$this->assign("sub_categories", $sub_categories);
    	$classifications = M('classification')->where("sub_category_id=%d", array($product_base['sub_category_id']))->select();
    	$this->assign("classifications", $classifications);
    	$this->display();
    }
    
    public function update_info(){
    	if( isset($_POST['product_base']) ){
    		$_POST['product_base']['file']=$_FILES['file'];
    		$res = D('ProductBase')->update_info($_POST['product_base']);
    		$notice = $res['msg'];
    		if( $res['status'] ){
    			$this->set_notice(1, $notice);
    			$this->redirect("ProductBase/index");
    		}
    	}else{
    		$notice = "参数错误";
    	}
    	$this->set_notice(2, $notice);
    	$this->redirect('ProductBase/edit', array('id'=>$_POST['product_base']['id']));
    }
    
    public function del(){
    	$f = M('product_base')->where("id=%d", array($_GET['id']))->setField(array('is_del'=>1));
    	if( $f!==false ){
    		$this->set_notice(1, "删除成功");
    	}else{
    		$this->set_notice(2, "删除出错，请重试");
    	}
    	$this->redirect("Product/index");
    }
    
    
    public function download_csv() {
    	include_once SITE_PATH.'/Home/Model/Export.class.php';
    	$titleList = array('大类名称', '产品系列', '产品类别', '物料代码','辅代码', '产品名称', '现价', '统一售价', '最低售价', '描述');
    	$where = "a.is_del=0";
    	if( !empty($_POST['key']) ){
    		$where .= " and a.name like '%".$this->str_filter($_POST['key'])."%'";
    	}
    	if( !empty($_POST['category_id']) ){
    		$where .= " and a.category_id=".intval($_POST['category_id']);
    	}
    	if( !empty($_POST['sub_category_id']) ){
    		$where .= " and a.sub_category_id=".intval($_POST['sub_category_id']);
    	}
    	if( !empty($_POST['classification_id']) ){
    		$where .= " and a.classification_id=".$this->str_filter($_POST['classification_id']);
    	}
    	
    	$arrs = M('product_base')->alias('a')->join( "left join ".C('DB_PREFIX')."category b on a.category_id=b.id ".
    												 "left join ".C('DB_PREFIX')."sub_category s on s.id=a.sub_category_id ".
    												 "left join ".C('DB_PREFIX')."classification c on c.id=a.classification_id")
		    	->field("b.name as category_name, s.name as sub_category_name, c.name as classification_name, a.number, ".
		    			"a.code, a.name, ifnull(a.now_price,0), ifnull(a.sold_price,0), ifnull(a.min_price,0), a.content")
		    	->where($where)->group('a.id')->order("a.create_time desc")->select();
    	$export = new \Export();
    	$export->export_csv($arrs, $titleList);
    }
    
    public function get_sub_categories(){
    	layout(false);
    	header("Content-type: text/html; charset=utf-8");
    	$sub_categories = M('sub_category')->where("category_id=%d and is_del=0 ", array($_POST['category_id']))->select();
    
    	//if( count($sub_categories)==0 ){
    	// $sub_categories = array(array('id'=>0, 'name'=>"请选择系列"));
    	//}
    	array_unshift($sub_categories, array('name'=>'请选择', 'id'=>0));
    	$this->assign('sub_categories', $sub_categories);
    	$this->display("ProductBase/_sub_categories");
    }
    
    public function get_classifications(){
    	layout(false);
    	header("Content-type: text/html; charset=utf-8");
    	$classifications = M('classification')->where("sub_category_id=%d and is_del=0 ", array($_POST['sid']))->select();
    
    	//if( count($classifications)==0 ){
    		$classifications = array(array('id'=>0, 'name'=>"请选择"));
    	//}
    	$this->assign('classifications', $classifications);
    	$this->display("ProductBase/_classifications");
    }

    
    
}