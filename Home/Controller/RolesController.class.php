<?php
namespace Home\Controller;
use Common\Common\Controller\AdminBaseController;
class RolesController extends AdminBaseController{
    
	public $locations = array();
	
	function __construct(){
		parent::__construct();
		$this->locations = array(
				array('is_checked'=>true, 'name'=>'部门管理', 'url'=>U('Roles/index'))
		);
		$this->assign('locations', $this->locations);
		$this->assign('loc_name_1', '角色管理');
	}
	
	public function index(){
		$this->assign('loc_name_2', '角色列表');
		$deports = M('deport')->where('is_del=0')->select();
		$this->assign('s_deports', $deports);
		$search_info['key'] = isset($_POST['key'])?$_POST['key']:'';
		$search_info['num'] = isset($_POST['num'])?intval($_POST['num']):intval($_GET['num']);
		$search_info['deport_id'] = isset($_POST['deport_id'])?intval($_POST['deport_id']):intval($_GET['deport_id']);
		$res = D('Roles')->search_info($search_info);
		$this->assign('roles', $res['roles']);
    	$this->assign('show_page', $res['show_page']);
    	$this->assign('Role', D('Roles'));
    	$this->assign('s_deports', D('Deport')->get_deports());
    	$this->assign('search_info', $search_info);
        $this->show();
    }
	
    public function add_info(){
    	$this->assign('loc_name_2', '添加角色');
    	$this->assign('role', array());
    	$deports = M('deport')->where('is_del=0')->select();
    	$this->assign('deports', $deports);
    	$s_menus = M('menus')->where("ptype=0")->select();
		foreach($s_menus as $i=>$value){
			$a = M('menus')->where("parent_id=%d", array($value['id']))->select();
			foreach($a as $j=>$val){
				$b = M('menus')->where("parent_id=%d", array($val['id']))->select();
				foreach($b as $k=>$v){
					$c = M('menus')->where("parent_id=%d", array($v['id']))->select();
					foreach($c as $n=>$va){
						$c[$n]['sub_menus'] = M('menus')->where("parent_id=%d", array($va['id']))->select();
					}
					$b[$k]['sub_menus'] = $c;
				}
				$a[$j]['sub_menus'] = $b;
			}
			$s_menus[$i]['sub_menus'] = $a;
		}
		$this->assign('s_menus', $s_menus);
    	$this->show();
    }
    
    public function create_info(){
    	 if( isset($_POST['role']) ){
    	 	$_POST['role']['admin_user_id'] = $this->admin_user_id;
    	 	$_POST['role']['ids'] = $_POST['ids'];
    	 	$_POST['role']['attach_power_ids'] = $_POST['attach_ids'];
    	 	$_POST['role']['text_power_ids'] = $_POST['text_ids'];
    	 	$_POST['role']['check_power_ids'] = $_POST['check_ids'];
    	 	$_POST['role']['shop_powers'] = $_POST['shop_powers'];
    	 	$res = D('Roles')->create_info($_POST['role']);
    	 	if( $res['status'] ){
    	 		$this->redirect("Home/Roles/index");
    	 		exit;
    	 	}else{
    	 		$_SESSION['notice'] = $res['msg'];
    	 	}
    	 }
    	 $this->redirect('Home/Roles/add_info');
    }
    
    public function edit(){
    	$this->assign('loc_name_2', '修改角色');
    	$role = M('roles')->where("id=%d", array(intval($_GET['id'])))->find();
    	$this->assign('role', $role);
    	$deports = M('deport')->where('is_del=0')->select();
    	$this->assign('deports', $deports);
    	$ids = M('role_menus')->where('role_id=%d', array($role['id']))->select();
    	$arr_ids = array();
    	foreach($ids as $v){
    		array_push($arr_ids, $v['menus_id']);
    	}
    	$this->assign('ids', $arr_ids);
    	$s_menus = M('menus')->where("ptype=0")->select();
    	foreach($s_menus as $i=>$value){
    		$a = M('menus')->where("parent_id=%d", array($value['id']))->select();
    		foreach($a as $j=>$val){
    			$b = M('menus')->where("parent_id=%d", array($val['id']))->select();
    			foreach($b as $k=>$v){
    				$c = M('menus')->where("parent_id=%d", array($v['id']))->select();
    				foreach($c as $n=>$va){
    					$c[$n]['sub_menus'] = M('menus')->where("parent_id=%d", array($va['id']))->select();
    				}
    				$b[$k]['sub_menus'] = $c;
    			}
    			$a[$j]['sub_menus'] = $b;
    		}
    		$s_menus[$i]['sub_menus'] = $a;
    	}
    	$this->assign('s_menus', $s_menus);
    	$this->show();
    }
    
    public function update_info(){
    	if( isset($_POST['role']) ){
    		$_POST['role']['ids'] = $_POST['ids'];
    		$_POST['role']['attach_power_ids'] = $_POST['attach_ids'];
    		$_POST['role']['text_power_ids'] = $_POST['text_ids'];
    		$_POST['role']['check_power_ids'] = $_POST['check_ids'];
    		$_POST['role']['shop_powers'] = $_POST['shop_powers'];
    		$res = D('Roles')->update_info($_POST['role']);
    		if( $res['status'] ){
    			$this->redirect("Home/Roles/index");
    		}else{
    			$_SESSION['notice'] = $res['msg'];
    		}
    	}else{
    		$_SESSION['notice'] = "参数错误";
    	}
    	$this->redirect('Home/Roles/add_info');
    }
    
    public function delete_role(){
    	$f = M('roles')->where("id=%d", array(intval($_GET['id'])))->delete();
    	if( $f!==false ){
    		$_SESSION['notice'] = "删除成功";
    	}else{
    		$_SESSION['notice'] = "删除失败";
    	}
    	$this->redirect('Home/Roles/index');
    }
	
}