<?php
namespace Home\Controller;
use Common\Common\Controller\AdminBaseController;
class ShopController extends AdminBaseController {
    
	public $locations = array();
	public $ptype_id;
	
	
	function __construct(){
		parent::__construct();
		$this->locations = array(
				array('is_checked'=>false, 'name'=>'店铺管理', 'url'=>U('Shop/index'))
		);
		$this->assign('loc_name_1', "店铺管理");
		$this->assign('locations', $this->locations);
	}
	
	public function index(){
		$this->assign("loc_name_2", "店铺列表");
		$search_info['key'] = isset($_POST['key'])?$_POST['key']:'';
		$search_info['num'] = isset($_POST['num'])?intval($_POST['num']):isset($_GET['num'])?intval($_GET['num']):10;
		$this->assign('search_info', $search_info);
		$res = D('Shop')->search_info($search_info);
		$this->assign('show_page', $res['show_page']);
		$col_status = M('ptype_status')->where("ptype_id=%d",array($search_info['ptype_id']))->field("id as val,name")->select();
		$this->assign('s_status', $col_status);
                $shop = M('shop')->order("id")->select();
                $mall =M('mall')->where("is_del=0")->select();
                $this->assign('mall',$mall);
                $this->assign('shop', $shop);
                $this->display();
    }
    
    public function add_info(){
    	$this->assign("loc_name_2", "添加");
        $mall = M('mall')->where("is_del=0")->select();
        $this->assign('shop_mall', $mall);
    	$this->display();
    }
    
    public function create_info(){
    	if( isset($_POST['shop']) ){

                if(isset($_POST['dh'])){
                    $f ;
                }

    		$_POST['shop']['admin_user_id'] = $this->admin_user_id;
    		$res = D('Shop')->create_info($_POST['shop']);
    		$notice = $res['notice'];
    		if( $res['status'] ){
    			$this->set_notice(1, $notice);
    			$this->redirect("Shop/index");
    		}
    	}else{
    		$notice = "参数错误";
    	}
    	$this->set_notice(2, $notice);
    	$this->redirect('Shop/add_info');
    }
    
    public function edit(){
    	$this->assign("loc_name_2", "修改");
        $shop = M('shop')->where("id=%d", array($_GET['id']))->find();
    	$mall = M('mall')->where("is_del=0")->select();
    	$this->assign("shop_mall", $mall);
        $this->assign('shop',$shop);
    	$this->display();
    }
    
    public function update_info(){
    	if( isset($_POST['shop']) ){
    		$res = D('Shop')->update_info($_POST['shop']);
    		$notice = $res['notice'];
    		if( $res['status'] ){
    			$this->set_notice(1, $notice);
    			$this->redirect("Shop/index");
    		}
    	}else{
    		$notice = "参数错误";
    	}
    	$this->set_notice(2, $notice);
    	$this->redirect('Shop/edit', array('id'=>$_POST['shop']['id']));
    }
    
    public function del(){
    	$f = M('shop')->where("id=%d", array($_GET['id']))->setField(array('status'=>2));
    	if( $f!==false ){
    		$this->set_notice(1, "删除成功");
    	}else{
    		$this->set_notice(2, "删除出错，请重试");
    	}
    	$this->redirect("Shop/index");
    }
    
    public function pass(){
    	$f = M('shop')->where("id=%d", array($_GET['id']))->setField(array('status'=>1));
    	if( $f!==false ){
    		$this->set_notice(1, "审核成功");
    	}else{
    		$this->set_notice(2, "审核出错，请重试");
    	}
    	$this->redirect("Shop/index");
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