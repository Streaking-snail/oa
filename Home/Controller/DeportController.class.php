<?php
namespace Home\Controller;
use Common\Common\Controller\AdminBaseController;
class DeportController extends AdminBaseController{
	
	public $locations = array();
	
	function __construct(){
		parent::__construct();
        $this->locations = array(
        		array('is_checked'=>false, 'name'=>'部门管理', 'url'=>U('Deport/index'))
        );
        $this->assign('locations', $this->locations);
        $this->assign('loc_name_1', '部门管理');
    }
	
    public function index(){
    	$this->assign('loc_name_2', '部门列表');
    	$search_info['num'] = isset($_POST['num'])?intval($_POST['num']):intval($_GET['num']);
    	$search_info['key'] = isset($_POST['key'])?$_POST['key']:'';
    	$this->assign('search_info', $search_info);
    	$res = D('Deport')->search_info( $search_info );
    	$this->assign('deports', $res['deports']);
    	$this->assign('show_page', $res['show_page']);
    	$this->assign('Deport', D('Deport'));
        $this->show();
    }
	public function add_info(){
		$this->assign('loc_name_2', '添加部门');
        $deport = array();
        $this->assign('deport', $deport);
        $this->show();
    }
    public function create_info(){
    	if( isset($_POST['deport']) ){
    		$_POST['deport']['admin_user_id'] = $this->admin_user_id;
    		$res = D('Deport')->create_info($_POST['deport']);
    		if( $res['status'] ){
    			$this->redirect("Home/Deport/index");
    		}else{
    			$_SESSION['notice'] = $res['msg'];
    		}
    	}else{
    		$_SESSION['notice'] = "参数错误";
    	}
    	$this->redirect('Home/Deport/add_info');
    }
    
    public function edit(){
    	$this->assign('loc_name_2', '修改部门');
    	$deport = M('deport')->where("id=%d", array($_GET['id']))->find();
    	$this->assign('deport', $deport);
    	$this->show();
    }
    public function update_info(){
    	if( isset($_POST['deport']) ){
    		$res = D('Deport')->update_info($_POST['deport']);
    		if( $res['status'] ){
    			$this->redirect("Home/Deport/index");
    		}else{
    			$_SESSION['notice'] = $res['msg'];
    		}
    	}else{
    		$_SESSION['notice'] = "参数错误";
    	}
    	$this->redirect('Home/Deport/edit', array('id'=>$_POST['deport']['id']));
    }
    
    //删除部门
    public function delete_deport(){
    	$f = M('deport')->where("id=%d",array(intval($_GET['id'])))->setField(array('is_del'=>1));
    	if( $f!==false ){
    		$_SESSION['notice']="删除部门成功";
    	}else{
    		$_SESSION['notice']="删除部门失败，请重新删除";
    	}
    	$this->redirect("Home/Deport/index");
    }
    
}