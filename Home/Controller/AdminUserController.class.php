<?php
namespace Home\Controller;
use Common\Common\Controller\AdminBaseController;
class AdminUserController extends AdminBaseController{

	public $locations = array();
	
	function __construct(){
		parent::__construct();
		$this->locations = array(
				array('is_checked'=>false, 'name'=>'人员管理', 'url'=>U('AdminUser/index'))
		);
		$this->assign('locations', $this->locations);
		$this->assign('loc_name_1', "人员管理");
	}
	
	public function index(){
		$this->assign('loc_name_2', "人员列表");
		$AdminUser = D('AdminUser');
		$search_info = array();
		$search_info['deport_id'] = isset($_POST['deport_id'])?intval($_POST['deport_id']):intval($_GET['deport_id']);
		$search_info['status'] = isset($_POST['status'])?intval($_POST['status']):0;
		$search_info['key'] = isset($_POST['key'])?$_POST['key']:'';
		$search_info['num'] = isset($_POST['num'])?intval($_POST['num']):10;
		$res = $AdminUser->search_info( $search_info );
		$this->assign('search_info', $search_info);
		$this->assign('admin_users', $res['admin_users']);
		$this->assign('show_page', $res['show_page']);
		$this->assign('s_deports', D('Deport')->get_deports());
		$this->assign('AdminUser', $AdminUser);
		$s_status = array(
			array('name'=>'所有', 'val'=>0),
			array('name'=>'正常', 'val'=>1),
			array('name'=>'锁定', 'val'=>2),
			array('name'=>'已删除', 'val'=>3),
		);
		$this->assign('page_number',$res['now_page']);
		$this->assign('s_status', $s_status);
		$this->show();
	}
	
	public function select_roles(){
		layout(false);
		header("Content-type: text/html; charset=utf-8");
		$roles = D('Roles')->get_roles_options($_GET['id']);
		$this->assign('roles', $roles);
		$this->display('AdminUser/_role');
	}
	
	public function add_info(){
		$this->assign('loc_name_2', "添加人员");
		$admin_user = array();
		$this->assign('admin_user', $admin_user);
		$this->assign('deports', D('Deport')->get_deports_options());
		$this->assign('roles', array(array('name'=>'请选择角色', 'id'=>0)));
		$this->assign('is_add', true);
		$this->show();
	}
	public function create_info(){
		if( isset($_POST['admin_user']) ){
			$_POST['admin_user']['admin_user_id'] = $this->admin_user_id;
			$res = D('AdminUser')->create_info( $_POST['admin_user'] );
			if( $res['status'] ){
				$this->set_notice(1, "添加人员成功");
				$this->redirect("AdminUser/index");
			}else{
				$this->assign('deports', D('Deport')->get_deports_options());
				if( intval($admin_user['deport_id'])>0 ){
					$this->assign('roles', D('Roles')->get_roles_options($_POST['admin_user']['deport_id']));
				}else{
					$this->assign('roles', array(array('name'=>'请选择角色', 'id'=>0)));
				}
				$this->assign('admin_user', $_POST['admin_user']);
				$notice = $res['msg'];
				$this->set_notice(2, $notice);
				$this->assign('is_add', true);
				$this->display('AdminUser/add_info');
				exit;
			}
		}else{
			 $notice = "参数错误";	
		}
		$this->set_notice(2, $notice);
		$this->redirect("AdminUser/add_info");
	}
	
	public function edit(){
		$this->locations = array(
				array('is_checked'=>false, 'name'=>'人员管理', 'url'=>"javascript:void(0);")
		);
		$this->assign('locations', $this->locations);
		$this->assign('loc_name_2', "修改人员");
	    $admin_user = D('AdminUser')->where('id='.intval($_GET['id']))->find();
		if( $admin_user ){
			$this->assign('deports', D('Deport')->get_deports_options());
			if( intval($admin_user['deport_id'])>0 ){
				$this->assign('roles', D('Roles')->get_roles_options($admin_user['deport_id']));
			}else{
				$this->assign('roles', array(array('name'=>'请选择角色', 'id'=>0)));
			}
			$this->assign('admin_user', $admin_user);
	    	$this->show();
	    }else{
	    	$_SESSION['notice'] = "参数错误";
	    	$this->redirect("AdminUser/index");
	    }
	}
	public function update_info(){
		if( isset($_POST['admin_user']) ){
			$res = D('AdminUser')->update_info( $_POST['admin_user'] );
			$notice = $res['msg'];
			if( $res['status'] ){
				$this->set_notice(1, $notice);
				$this->redirect("AdminUser/index");
				exit;
			}
		}else{
			$notice = "参数错误";
		}
		$this->assign(2, $notice);
  	    $this->redirect("Home/AdminUser/edit", array('id'=>$_POST['admin_user']['id']));
	}
	
	//修改密码
	public function edit_password(){
		$this->locations = array(
				array('is_checked'=>false, 'name'=>'人员管理', 'url'=>"javascript:void(0);")
		);
		$this->assign('locations', $this->locations);
		$this->assign('loc_name_2', "修改密码");
		if( isset($_POST['password']) && isset($_POST['confirm_password']) ){
			$res = D('AdminUser')->edit_password($_POST['password'], $_POST['confirm_password'], $this->admin_user_id);
			if( $res['status'] ){
				$this->set_notice(1, $res['msg']);
				$this->redirect('Home/Login/index');
			}else{
				$this->set_notice(2, $res['notice']);
			}
		}
		$this->assign('id', $_GET['id']);
		$this->show();
	}
	
	public function delete_user(){
		$admin_user =  M('admin_user')->where("id=%d",array($_GET['id']))->find();
		$f = M('admin_user')->where("id=%d",array($_GET['id']))->setField(array('is_del'=>1, "username"=>$admin_user['username'].$_GET['id']));
		if( $f!==false ){
			$this->set_notice(1,"删除成功");
		}else{
			$this->set_notice(2, "删除失败，请重试");
		}
		$this->redirect("Home/AdminUser/index");
	}
	
	public function lock(){
		$f = M('admin_user')->where("id=%d",array($_GET['id']))->setField(array('status'=>1));
		if( $f!==false ){
			$this->set_notice(1,"锁定成功");
		}else{
			$this->set_notice(2,"锁定失败，请重试");
		}
		$this->redirect("Home/AdminUser/index");
	}
	
	public function unlock(){
		$f = M('admin_user')->where("id=%d",array($_GET['id']))->setField(array('status'=>2));
		if( $f!==false ){
			$this->set_notice(1, "解锁成功");
		}else{
			$this->set_notice(2, "解锁失败，请重试");
		}
		$this->redirect("AdminUser/index");
	}
	
	public function detail(){
		$AdminUser = D('AdminUser');
		$admin_user = $AdminUser->where("id=%d", array($_GET['id']))->find();
		$this->assign('admin_user', $admin_user);
		$this->assign('AdminUser', $AdminUser);
		$this->show();
	}
	
	//删除测试账号数据
	public function delete_test_user_info(){
		if( isset($_GET['id']) ){
		 $user = M('admin_user')->where("is_test=1 and id=%d", array($_GET['id']))->find();
		 if( $user ){
		 	M()->startTrans();
		 	$f1 = M('admin_user_log')->where("admin_user_id=%d", array($user['id']))->delete();
		 	$f2 = M('admin_user_show')->where("admin_user_id=%d", array($user['id']))->delete();
		 	
// 		 	$f3 = M('count_info_status_attach')->alias("a, ".C('DB_PREFIX')."count_info_status b, ".C('DB_PREFIX')."count_info c, ".C('DB_PREFIX')."product d")
// 		 			->where("a.count_info_status_id=b.id and b.count_info_id=c.id and d.id=c.product_id and d.admin_user_id=%d", array($user['id']))->delete();
		 	$f3 = M('count_info_status_attach')->where("admin_user_id=%d", array($user['id']))->delete();
		 	
// 		 	$f4 = M('count_info_status')->alias("a")->join("left join ".C('DB_PREFIX')."count_info b on b.id=a.count_info_id".
// 				 	"left join ".C('DB_PREFIX')."product c on c.id=b.product_id")
// 				 	->where("c.admin_user_id=%d", array($user['id']))->delete();
		 	$f4 = M('count_info_status')->where("admin_user_id=%d", array($user['id']))->delete();
		 	
// 		 	$f5 = M('count_info')->alias("a")->join("left join ".C('DB_PREFIX')."product b on b.id=a.product_id")
// 		 		->where("b.admin_user_id=%d", array($user['id']))->delete();
		 	$f5 = M('count_info')->where("admin_user_id=%d", array($user['id']))->delete();
		 	
		 	$f6 = M('products')->where("admin_user_id=%d", array($user['id']))->delete();
// 		 	$f7 = M('product_order_deliver')->alias("a")
// 		 			->join("left join ".C('DB_PREFIX')."product_order b on b.id=a.product_order_id")
// 		 			->where("b.admin_user_id=%d", array($user['id']))->delete();
		 	$f7 = M('product_order_deliver')->where("admin_user_id=%d", array($user['id']))->delete();
		 	
		 	$f8 = M('product_order')->where("admin_user_id=%d", array($user['id']))->delete();
		 	
// 		 	$f9 = M('product_pic_status_log')->alias("c")
// 		 		->join("left join ".C('DB_PREFIX')."product_pic_status b on b.id=c.product_pic_status_id".
// 		 			" left join ".C('DB_PREFIX')."product_pic a on b.product_pic_id=a.id")
// 		 		->where("a.admin_user_id=%d", array($user['id']))->delete();
		 	$f9 = M('product_pic_status_log')->where("admin_user_id=%d", array($user['id']))->delete();
		 	
// 		 	$f10 = M('product_pic_status_attach')->alias("c")
// 			 	->join("left join ".C('DB_PREFIX')."product_pic_status b on b.id=c.product_pic_status_id".
// 			 	" left join ".C('DB_PREFIX')."product_pi a on b.product_pic_id=a.id")
// 			 	->where("a.admin_user_id=%d", array($user['id']))->delete();
		 	$f10 = M('product_pic_status_attach')->where("admin_user_id=%d", array($user['id']))->delete();
		 	
// 		 	$f11 = M('product_pic_status')->alias("a")
// 			 	->join("left join ".C('DB_PREFIX')."product_pic b on b.product_pic_id=a.id")
// 			 	->where("a.admin_user_id=%d", array($user['id']))->delete();
		 	$f11 = M('product_pic_status')->where("admin_user_id=%d", array($user['id']))->delete();
		 	
		 	$f12 = M('product_pic')->where("admin_user_id=%d", array($user['id']))->delete();
		 	$f13 = M('product_base')->where("admin_user_id=%d", array($user['id']))->delete();
		 	if( $f1!==false && $f2!==false && $f3!==false && $f4!==false&& $f5!==false&&
		 			$f6!==false&& $f7!==false&& $f8!==false&&$f9!==false&& $f10!==false&&
		 			$f11!==false&& $f12!==false&& $f13!==false ){
			 	M()->commit();
			 	$this->set_notice(1, "清除数据成功");
			 }else{
			 	M()->rollback();
			 	$this->set_notice(2, "清除数据失败");
			 }
		 }else{
		 	$this->set_notice(2, "清除数据失败");
		 }
		}else{
			$this->set_notice(2, "参数错误");
		}
		 $this->redirect("AdminUser/index");
	}
	
}