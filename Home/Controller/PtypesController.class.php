<?php
namespace Home\Controller;
use Common\Common\Controller\AdminBaseController;
class PtypesController extends AdminBaseController {
    
	public $locations = array();
	
	function __construct(){
		parent::__construct();
		$this->locations = array(
				array('is_checked'=>true, 'name'=>'基础配置', 'url'=>'javascript:void(0);')
		);
		$this->assign('loc_name_1', "流程说明资料");
		$this->assign('locations', $this->locations);
	}
	
	public function index(){
		$this->assign('loc_name_2', "操作说明列表");
		$search_info['num'] = isset($_POST['num'])?intval($_POST['num']):intval($_GET['num']);
    	$search_info['key'] = isset($_POST['key'])?$_POST['key']:'';
    	$this->assign('search_info', $search_info);
    	$Ptype = D('Ptypes');
		$res = $Ptype->search_info($search_info);
		$this->assign('p_types', $res['ptypes']);
		$this->assign('Ptype', $Ptype);
		$this->assign('show_page', $res['show_page']);
		$this->show();
	}
	public function add_info(){
		$this->assign('is_kindeditor', true);
		$this->assign('loc_name_2', '添加分类');
        $deport = array();
        $this->assign('deport', $deport);
        $this->show();
    }
    public function create_info(){
    	if( isset($_POST['ptype']) && isset($_POST['ptype_status']) ){
    		$_POST['ptype']['admin_user_id'] = $this->admin_user_id;
    		$params = $_POST['ptype'];
    		$params['ptype_statuses'] = $_POST['ptype_status'];
    		$res = D('Ptypes')->create_info($params);
    		if( $res['status'] ){
    			$this->redirect("Home/Ptypes/index");
    		}else{
    			$_SESSION['notice'] = $res['msg'];
    		}
    	}else{
    		$_SESSION['notice'] = "参数错误";
    	}
    	$this->redirect('Home/Ptypes/add_info');
    }
    
    public function edit(){
    	$this->assign('is_kindeditor', true);
    	$this->assign('loc_name_2', '修改说明');
    	$ptype = M('ptypes')->where("id=%d", array($_GET['id']))->find();
    	$this->assign('ptype', $ptype);
    	$ptype_status = M('ptype_status')->where("ptype_id=%d", array($ptype['id']))->order("rank asc,id")->select();
    	$this->assign('ptype_status', $ptype_status);
    	$this->show();
    }
    public function update_info(){
    	if( isset($_POST['ptype']) ){
    		$_POST['ptype']['ptype_statuses'] = $_POST['ptype_status'];
    		$res = D('Ptypes')->update_info($_POST['ptype']);
    		if( $res['status'] ){
    			$this->redirect("Home/Ptypes/index");
    			exit;
    		}else{
    			$_SESSION['notice'] = $res['msg'];
    		}
    	}else{
    		$_SESSION['notice'] = "参数错误";
    	}
    	$this->redirect('Home/Ptypes/edit', array('id'=>$_POST['ptype']['id']));
    }
    
    public function detail(){
    	$Ptype = D('Ptypes');
    	$this->assign('loc_name_2', '详情');
    	$p_type = $Ptype->where("id=%d", array($_GET['id']))->find();
    	$this->assign('p_type', $p_type);
    	$this->assign('Ptype', $Ptype);
    	$this->display();
    }
    
    //删除部门
    public function ptype_delete(){
    	$f = M('ptypes')->where("id=%d",array(intval($_GET['id'])))->setField(array('is_del'=>1));
    	if( $f!==false ){
    		$_SESSION['notice']="删除分类成功";
    	}else{
    		$_SESSION['notice']="删除分类失败，请重新删除";
    	}
    	$this->redirect("Home/Ptypes/index");
    }
	
}