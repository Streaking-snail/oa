<?php
namespace Home\Controller;
use Common\Common\Controller\AdminBaseController;
class MallController extends AdminBaseController {
    
	public $locations = array();
	public $ptype_id;
	
	
	function __construct(){
		parent::__construct();
		$this->locations = array(
				array('is_checked'=>false, 'name'=>'商城管理', 'url'=>U('Mall/index'))
		);
		$this->assign('loc_name_1', "商城管理");
		$this->assign('locations', $this->locations);
	}
	
	public function index(){
		$this->assign("loc_name_2", "商城列表");
		$search_info['key'] = isset($_POST['key'])?$_POST['key']:'';
		$search_info['num'] = isset($_POST['num'])?intval($_POST['num']):isset($_GET['num'])?intval($_GET['num']):10;
		$this->assign('search_info', $search_info);
		$res = D('Mall')->search_info($search_info);
                $mall = M('mall')->where("is_del=0")->order("rank,id")->select();
                $this->assign('mall', $mall);
		$this->assign('show_page', $res['show_page']);
                
                $this->display("Mall/index");
    }
    
    public function add_info(){
    	$this->assign("loc_name_2", "添加");
    	$this->display();
    }
    
    public function create_info(){
        
        if( isset($_POST['mall']) && isset($_POST['mall_detail']) ){
    		$params = $_POST['mall'];
    		$params['detail'] = $_POST['mall_detail'];
    		$res = D('Mall')->create_info($params);
    		if( $res['status'] ){
    			$this->redirect("Mall/index");
                        
    		}else{
    			$_SESSION['notice'] = $res['msg'];
    		}
    	}else{
    		$_SESSION['notice'] = "参数错误";
    	}
    	$this->redirect('Mall/add_info');
    	
    }
    
    public function edit(){
    	$this->assign("loc_name_2", "修改");
    	$mall = M('mall')->where("id=%d", array($_GET['id']))->find();
    	$this->assign("mall", $mall);
    	
        $colums = M('mall_colums')->where("mall_id=%d",array($_GET['id']))->order("rank asc,id")->select();
        $this->assign("colums",$colums);
        
        $ptype_status = M('ptype_status')->where("ptype_id=3")->order("rank asc, id")->select();
        array_unshift($ptype_status, array('name'=>'到货时间', 'id'=>10));
        array_unshift($ptype_status, array('name'=>'自定义', 'id'=>0));
        $this->assign("ptype_status", $ptype_status);
    	
    	$this->display();
    }
    
    public function update_info(){
    	if( isset($_POST['mall']) ){
            $params = $_POST['mall'];
    		$params['detail'] = $_POST['mall_detail'];
    		$res = D('Mall')->update_info($params);
            $id=$_POST['mall']['id'];
    		if( $res['status'] ){
    			$this->set_notice(1, $notice);
    			$this->redirect("Mall/index");
    		}
    	}else{
    		$notice = "参数错误";
    	}
    	$this->set_notice(2, $notice);
    	$this->redirect('Mall/edit', array('id'=>$id));
    }
    
    public function del(){
    	$f = M('mall')->where("id=%d", array($_GET['id']))->setField(array('is_del'=>1));
    	if( $f!==false ){
    		$this->set_notice(1, "删除成功");
    	}else{
    		$this->set_notice(2, "删除出错，请重试");
    	}
    	$this->redirect("Mall/index");
    }
    
    
}