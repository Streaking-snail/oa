<?php
namespace Home\Controller;
use Common\Common\Controller\AdminBaseController;
class ProductController extends AdminBaseController {
    
	public $locations = array();
	public $category_id,$sub_category_id, $classification_id;
	
	function __construct(){
		parent::__construct();
		$this->locations = array(
				array('is_checked'=>false, 'name'=>'产品管理', 'url'=>U('Product/index'))
		);
        $this->category_id = isset($_POST['category_id'])?intval($_POST['category_id']):(isset($_GET['category_id'])?$_GET['category_id']:0);
        $this->sub_category_id = isset($_POST['sub_category_id'])?intval($_POST['sub_category_id']):isset($_GET['sub_category_id'])?$_GET['sub_category_id']:0;
        $this->classification_id = isset($_POST['classification_id'])?intval($_POST['classification_id']):isset($_GET['classification_id'])?$_GET['classification_id']:0;
        $this->assign('loc_name_1', "产品管理");
		$this->assign('locations', $this->locations);
	}
	
	public function index(){
		$this->assign("loc_name_2", "产品列表");
		$search_info['key'] = isset($_POST['key'])?$_POST['key']:'';
		$search_info['category_id'] = $this->category_id;
		$search_info['sub_category_id'] = $this->sub_category_id;
		$search_info['classification_id'] = $this->classification_id;
		$search_info['number'] = $_POST['number'];
		$search_info['num'] = isset($_POST['num'])?intval($_POST['num']):(isset($_GET['num'])?intval($_GET['num']):10);
                $search_info['code'] = isset($_POST['code'])?$_POST['code']:'';
                $search_info['number'] = isset($_POST['number'])?$_POST['number']:'';
                $search_info['name'] = isset($_POST['name'])?$_POST['name']:'';
                $search_info['price'] = isset($_POST['price'])?$_POST['price']:'';
                $search_info['price1'] = isset($_POST['price1'])?intval($_POST['price1']):'';
                $search_info['price2'] = isset($_POST['price2'])?intval($_POST['price2']):'';
                $search_info['ptime1'] = isset($_POST['ptime1'])?intval(strtotime($_POST['ptime1'])):'';
                $search_info['ptime2'] = isset($_POST['ptime2'])?intval(strtotime($_POST['ptime2'])):'';
                $search_info['show'] = isset($_POST['show'])?intval($_POST['show']):'0';
		$this->assign('search_info', $search_info);
		$Product = D('Product');
		$res = $Product->search_info($search_info);
		$this->assign('is_number', 1);
		$this->assign('Product', $Product);
		$this->assign('products', $res['products']);
		$s_categories = D('Category')->s_get_category_options();
		$this->assign('s_categories', $s_categories);
		$this->assign('show_page', $res['show_page']);
		$col_status = M('ptype_status')->where("ptype_id=%d",array($search_info['ptype_id']))->field("id as val,name")->select();
        $total_count = M('products')->select();
		$this->assign('s_status', $col_status);
        $this->assign('number_per_page',$search_info['num']);
        $this->assign('page_number',$res['now_page']);
        $this->assign('total_count',count($total_count));
        $this->assign('is_more_search', 1);
        $this->assign('is_develop', 1);
    	$this->display();
    }
    
    public function get_sub_categories(){
    	layout(false);
    	header("Content-type: text/html; charset=utf-8");
        $sub_categories = M('sub_category')->where("category_id=%d", array($_POST['category_id']))->select();
        
    	//if( count($sub_categories)==0 ){ 
           // $sub_categories = array(array('id'=>0, 'name'=>"请选择系列")); 
        //}
            array_unshift($sub_categories, array('name'=>'请选择系列', 'id'=>0));
    	$this->assign('sub_categories', $sub_categories);
    	$this->display("Product/_sub_categories");
    } 
    
    public function get_classifications(){
    	layout(false);
    	header("Content-type: text/html; charset=utf-8");
        $classifications = M('classification')->where("sub_category_id=%d", array($_POST['sid']))->select();
        
    	if( count($classifications)==0 ){ 
            $classifications = array(array('id'=>0, 'name'=>"请选择类别")); 
        }
    	$this->assign('classifications', $classifications);
    	$this->display("Product/_classifications");
    }
    
    public function add_info(){
    	$this->assign("loc_name_2", "添加");
    	$categories = D('Category')->get_category_options();
        //var_dump($categories);die;
    	$this->assign("categories", $categories);
    	$this->assign("sub_categories", array(array('id'=>0, "name"=>"请选择系列")));
   	
        $this->assign("classifications", array(array('id'=>0, "name"=>"请选择类别")));
    	$this->assign('product', array('category_id'=>$this->category_id, 'sub_category_id'=>$this->sub_category_id, 'classification_id'=>$this->classification_id));
    	$this->display();
    }
    
    public function create_info(){
    	if( isset($_POST['product']) ){
    		$_POST['product']['admin_user_id'] = $this->admin_user_id;
            $_POST['product']['file']=$_FILES['file'];
            $res = D('Product')->create_info($_POST['product']);
    		$notice = $res['msg'];
    		if( $res['status'] ){
    			$this->set_notice(1, $notice);
                $this->assign("categories", $categories);
                $this->assign("sub_categories", $sub_categories);
    			$this->assign('product', $_POST['product']);
    			$this->redirect("Product/index");
                exit;
    		}else{
                $this->set_notice(2, $notice);
    			$categories = D('Category')->get_category_options();
    			$this->assign("categories", $categories);
    			$sub_categories = M('sub_category')->where("category_id=%d", array($_POST['product']['category_id']))->select();
    			$this->assign("sub_categories", $sub_categories);
    			$classifications = M('classification')->where("sub_category_id=%d", array($_POST['product']['sub_category_id']))->select();
    			$this->assign("classifications", $classifications);
    			$this->assign('product', $_POST['product']);
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
    	$product = M('products')->where("id=%d", array($_GET['id']))->find();
    	$this->assign("product", $product);
    	$categories = D('Category')->get_category_options();
    	$this->assign("categories", $categories);
    	$sub_categories = M('sub_category')->where("category_id=%d", array($product['category_id']))->select();
    	$this->assign("sub_categories", $sub_categories);
    	$classifications = M('classification')->where("sub_category_id=%d", array($product['sub_category_id']))->select();
    	$this->assign("classifications", $classifications);
    	$this->display();
    }
    
    public function update_info(){
    	if( isset($_POST['product']) ){
    		$_POST['product']['file']=$_FILES['file'];
    		$_POST['product']['admin_user_id'] = $this->admin_user_id;
    		$res = D('Product')->update_info($_POST['product']);
    		$notice = $res['msg'];
    		if( $res['status'] ){
    			$this->set_notice(1, $notice);
    			$this->redirect("Product/index");
    		}
    	}else{
    		$notice = "参数错误";
    	}
    	$this->set_notice(2, $notice);
    	$this->redirect('Product/edit', array('id'=>$_POST['product']['id']));
    }
    
    public function del(){
    	$f = M('products')->where("id=%d", array($_GET['id']))->setField(array('status'=>3));
    	if( $f!==false ){
    		$this->set_notice(1, "删除成功");
    	}else{
    		$this->set_notice(2, "删除出错，请重试");
    	}
    	$this->redirect("Product/index");
    }
    
    public function checked(){
    	$f = M('products')->where("id=%d", array($_GET['id']))->setField(array('status'=>1));
    	$r = M('product_order')->where('product_id=%d', array(intval($_GET['id'])))->find();
    	if( !$r ){
    		$i = M('product_order')->add(array('product_id'=>intval($_GET['id']), 'admin_user_id'=>$this->admin_user_id, 'create_time'=>time(),"update_time"=>time()));
                $name = M('products')->where("id=%d",array($_GET['id']))->find();
                $subject = "产品开发审核通过";
                $body = "产品";
                $body .= $name['name'];
                $body .="已审核通过";
                $mails = M('admin_user')->where("is_mail=1 and is_del=0 and email!=''")->select();
                $addresses = array();
                foreach($mails as $v){
//                    array_push($addresses, $v['email']);
                    $re = D('AdminUser')->send_mail($subject,$body,$v['email']);
                }
//                $re = D('AdminUser')->send_mail($subject,$body,$addresses);
    	}else{
    		M('product_order')->where("product_id=%d", array(intval($_GET['id'])))->setField(array('update_time'=>time(), 'admin_user_id'=>$this->admin_user_id));
    	}
    	if( $f!==false ){
    		$this->set_notice(1, "审核通过操作成功");
    	}else{
    		$this->set_notice(2, "审核通过操作失败");
    	}
    	$this->redirect("Product/index");
    }
    
    public function unchecked(){
    	$f = M('products')->where("id=%d", array($_GET['id']))->setField(array('status'=>2));
    	if( $f!==false ){
    		$this->set_notice(1, "审核不通过操作成功");
    	}else{
    		$this->set_notice(2, "审核不通过操作失败");
    	}
    	$this->redirect("Product/index");
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
    
    public function get_product_base_info(){
    	if( isset($_GET['q']) && !empty($_GET['q']) ){
    		$_GET['q'] = $this->str_filter($_GET['q']);
    		$product_bases = M('product_base')
			    		->where("(a.name like '%".$_GET['q']."%' or a.code like '%".$_GET['q']."%' or a.number like '%".$_GET['q']."%') and b.is_del=0")->select();
    		if( count($product_bases)>0 ){
    			$str = "";
    			foreach($product_bases as $value){
    				$str .= json_encode($value)."\n";
    			}
    			echo $str;
    			exit;
    		}
    	}
    	json_encode(array('id'=>0,'msg'=>'暂无记录'))."\n";
    	exit;
    }
       
}