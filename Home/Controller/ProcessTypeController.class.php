<?php
namespace Home\Controller;
use Common\Common\Controller\AdminBaseController;
class ProcessTypeController extends AdminBaseController{
	
	public $locations = array();
	
	function __construct(){
		parent::__construct();
        $this->locations = array(
        		array('is_checked'=>false, 'name'=>'工作流程配置', 'url'=>U('ProcessType/index'))
        );
        $this->assign('locations', $this->locations);
        $this->assign('loc_name_1', '工作流程配置');
    }
	
    public function index(){
    	$this->assign('loc_name_2', '列表');
    	$search_info['num'] = isset($_POST['num'])?intval($_POST['num']):intval($_GET['num']);
    	$search_info['key'] = isset($_POST['key'])?$_POST['key']:'';
    	$this->assign('search_info', $search_info);
    	$res = D('ProcessType')->search_info( $search_info );
    	$this->assign('process_types', $res['process_types']);
    	$this->assign('show_page', $res['show_page']);
    	$this->assign('page_number', $res['page_number']);
    	$this->assign('ProcessType', D('ProcessType'));
        $this->show();
    }
    
    public function edit(){
    	$this->assign('loc_name_2', '修改');
    	$process_type = M('process_types')->where("id=%d", array($_GET['id']))->find();
    	$this->assign('process_type', $process_type);
    	$process_type_status = M('process_type_status')->alias("a")
    						   ->join("left join ".C('DB_PREFIX')."admin_user b on b.id=a.checked_user_id")
    						   ->field("a.*,b.username as username")
    						   ->where("a.process_type_id=%d", array($_GET['id']))->order("rank asc,id")->select();
    	$this->assign("process_type_status", $process_type_status);
    	$this->show();
    }
    public function update_info(){
    	if( isset($_POST['process_type']) ){
    		$_POST['process_type']['process_type_status'] = $_POST['process_type_status'];
    		$res = D('ProcessType')->update_info($_POST['process_type']);
    		if( $res['status'] ){
    			$this->set_notice(1, $res['msg']);
    			$this->redirect("ProcessType/index");
    		}else{
    			$this->set_notice(2, $res['msg']);
    			header("Content-type: text/html; charset=utf-8");
    			$this->assign('process_type_status', $_POST['process_type']['process_type_status']);
    			$this->assign('process_type', $_POST['process_type']);
    			$this->display("edit");
    			exit;
    		}
    	}else{
    		$this->set_notice(2, "参数错误");
    	}
    	$this->redirect('ProcessType/edit', array('id'=>$_POST['process_type']['id']));
    }
    
    //删除部门
    public function delete_process_type(){
    	$f = M('process_types')->where("id=%d",array(intval($_GET['id'])))->setField(array('is_del'=>1));
    	if( $f!==false ){
    		$_SESSION['notice']="删除部门成功";
    	}else{
    		$_SESSION['notice']="删除部门失败，请重新删除";
    	}
    	$this->redirect("ProcessType/index");
    }
    
}