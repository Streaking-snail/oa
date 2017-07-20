<?php
namespace Home\Controller;
use Common\Common\Controller\AdminBaseController;
class IndexController extends AdminBaseController {
    
	public function index(){
		$this->set_notice(4, '登录成功');
		$this->assign('loc_name_1', '首页');
		$Items = D('Items');
		$total_count_info = D('Items')->total_count_info();
		$this->assign('count_info', $total_count_info);
		$this->assign('Items', $Items);
// 		$ptypes = M('ptypes')->where("is_del=0 and status=1")->select();
		
// 		foreach($ptypes as $k=>$value){
// 			$ptypes[$k]['item_infos'] = $Items->get_items($value['id']);
// 		}
		
		$products = D('Product')->where("status<3")->order("status asc,create_time desc")->limit(5)->select();

//                echo D()->getlastsql();
//                exit;
		$this->assign('aproducts', $products);
		
		$product_orders = D('ProductOrder')->alias("a")->join("left join ".C('DB_PREFIX')."products p on p.id=a.product_id")
						->field("a.*, p.name, p.code, p.number")
						->where("a.is_del=0")->order("a.update_time desc")->limit(5)->select();
		$this->assign('product_orders', $product_orders);
		
		$this->assign("Product", D('Product'));
		
		$ptypes = M('ptypes')->where("id=3")->select();
		foreach($ptypes as $k=>$value){
			$product_pics = M('product_pic')->alias("a")->join("left join ".C('DB_PREFIX')."products p on p.id=a.product_id")
							  ->field("a.*, p.name, p.code, p.number")
							  ->where("a.is_over=0")->select();
			$ptypes[$k]['item_infos'] = $product_pics;
		}
		$this->assign('ptypes', $ptypes);
		//$r_items = M('items')->where("is_del=0 and is_over=0")->select();
		//$this->assign('r_items', $r_items);
		$time = time()-3600*24*3;
		if( $this->user_info['is_admin']==1 ){
			$where = "a.create_time>=".$time;
		}else{
			$where = "a.deport_id=".intval($this->user_info['deport_id'])." and a.create_time>=".$time;
		}
		$where .= " or a.deport_id=0";
		$msgs = M('deport_message')->alias('a')->join("left join ".C('DB_PREFIX')."admin_user u on u.id=a.admin_user_id")
			    ->where($where)
			    ->field("a.id, a.admin_user_id, a.msg, a.create_time, ifnull(u.name, u.username) as username, u.head_pic")
				->order("a.create_time desc")->select();
		$this->assign('msgs', $msgs);
    	$this->display();
    }
    
    //发送信息
    public function send_msg(){
    	if( isset($_POST['message']) ){
    		$id = M('deport_message')->add(array(
    				'msg'=>$_POST['message'], 'deport_id'=>$this->user_info['deport_id'],
    				'admin_user_id'=>$this->admin_user_id,'create_time'=>time()));
    		if( $id>0 ){
    			layout(false);
				header("Content-type: text/html; charset=utf-8");
		    	$time = time()-3600*24*3;
				if( $this->user_info['is_admin']==1 ){
					$where = "a.create_time>=".$time;
				}else{
					$where = "a.deport_id=".intval($this->user_info['deport_id'])." and a.create_time>=".$time;
				}
				$msgs = M('deport_message')->alias('a')->join("left join ".C('DB_PREFIX')."admin_user u on u.id=a.admin_user_id")
				    ->where($where)
				    ->field("a.msg, a.admin_user_id, a.create_time, ifnull(u.name, u.username) as username, u.head_pic")
					->order("a.create_time desc")->select();
				$this->assign('msgs', $msgs);
				$this->display('Index/_msg_list');
    		}else{
    			echo "no";
    		}
    	}else{
    		echo "params";
    	}
    	exit;
    }
    
    public function get_all_msg(){
    	layout(false);
    	header("Content-type: text/html; charset=utf-8");
    	$time = time()-3600*24*3;
		if( $this->user_info['is_admin']==1 ){
			$where = "a.create_time>=".$time;
		}else{
			$where = "a.deport_id=".intval($this->user_info['deport_id'])." and a.create_time>=".$time;
		}
		$where .= " or a.deport_id=0";
    	$msgs = M('deport_message')->alias('a')->join("left join ".C('DB_PREFIX')."admin_user u on u.id=a.admin_user_id")
		    	->where($where)
		    	->field("a.id, a.msg, a.create_time, ifnull(u.name, u.username) as username, u.head_pic")
		    	->order("a.create_time desc")->select();
    	$this->assign('msgs', $msgs);
    	$this->display('Index/_msg_list');
    }
    
    //获取信息失败
    public function delete_msg(){
    	$f = M('deport_message')->where("id=%d", array($_POST['id']))->delete();
    	if( $f!==false ){
    		echo "yes";
    	}else{
    		echo "no";
    	}
    	exit;
    }
    
    public function selected_show(){
    	$AdminUserShow = M('admin_user_show');
    	if( $t=='d' ){
    		$f = $AdminUserShow->where("code='%s' and admin_user_id=%d",array($_POST['code'], $_SESSION['admin_user_id']))->delete();
    	}else{
    		$admin_user_show = $AdminUserShow->where("code='%s' and admin_user_id=%d",array($_POST['code'], $_SESSION['admin_user_id']))->find();
    		if( $admin_user_show ){
    			$f = true;
    		}else{
    			if( isset($_POST['cl']) && !empty($_POST['cl']) ){
    				$AdminUserShow->where("is_background=1 and admin_user_id=%d",array($_SESSION['admin_user_id']))->delete();
    				$f = $AdminUserShow->add(array('code'=>$_POST['code'], 'admin_user_id'=>$_SESSION['admin_user_id'], 'is_background'=>1));
    			}else{
    				switch( $_POST['code'] ){
    					case 'ace-settings-navbar':
    						$arrs = array('ace-settings-navbar');
    						break;
    					case 'ace-settings-sidebar':
    						$arrs = array('ace-settings-navbar', 'ace-settings-sidebar');
    						break;
    					case 'ace-settings-breadcrumbs':
    						$arrs = array('ace-settings-navbar', 'ace-settings-sidebar', 'ace-settings-breadcrumbs');
    						break;
    					case 'ace-settings-hover':
    						$arrs = array('ace-settings-hover');
    						break;
    					case 'ace-settings-compact':
    						$arrs = array('ace-settings-hover', 'ace-settings-compact');
    						break;
    					case 'ace-settings-highlight':
    						$arrs = array('ace-settings-highlight');
    						break;
    					case 'ace-settings-add-container':
    						$arrs = array('ace-settings-add-container');
    						break;
    				}
    				foreach( $arrs as $v ){
    					$admin_user_show = $AdminUserShow->where("code='%s' and admin_user_id=%d",array($v, $_SESSION['admin_user_id']))->find();
    					if( !$admin_user_show ){
    						$AdminUserShow->add(array('code'=>$v, 'admin_user_id'=>$_SESSION['admin_user_id'], 'is_background'=>0));
    					}
    				}
    				$f = true;
    			}
    		}
    	}
    	if( $f ){
    		echo "yes";
    	}else{
    		echo "no";
    	}
    	exit;
    }
    
    public function mail() {
    	import('PHPMailer');
    	import('PHPSmtp');
    	
    	$Subject = $_GET['title'];
    	$body = $_GET['content'];
    	$address = $_GET['email'];
    	
    	$re = D('AdminUser')->send_mail($Subject, $body, $address);
    	if( $re ){
    		echo "yes";
    	}else{
    		echo "no";
    	}
    	exit;
    }
    
    public function get_deport(){
    	if( isset($_GET['q']) ){
    		$deports = M('deport')->where("name like '%".$this->str_filter($_GET['q'])."%'")->select();
    		if( count($deports)>0 ){
	    		$str = "";
	    		foreach($deports as $value){
	    			$str .= json_encode($value)."\n";
	    		}
	    		echo $str;
    		}else{
    			echo json_encode(array('id'=>0,'name'=>'暂无相关记录'))."\n";
    		}
    	}else{
    		json_encode(array('id'=>0,'name'=>'参数错误'))."\n";
    	}
    	exit;
    }
    
    public function get_user(){
    	if( isset($_GET['q']) ){
    		$admin_users = M('admin_user')->alias("a")
    						->join("left join ".C("DB_PREFIX")."roles r on r.id=a.role_id")
    						->join("left join ".C("DB_PREFIX")."deport d on d.id=r.deport_id")
    						->field("a.id, a.username, a.name, d.name as deport_name, d.id as deport_id")
    						->where("a.name like '%".$this->str_filter($_GET['q'])."%' or a.username like '%".$this->str_filter($_GET['q'])."%'")
    						->select();
    		if( count($admin_users)>0 ){
	    		$str = "";
	    		foreach($admin_users as $value){
	    			$str .= json_encode($value)."\n";
	    		}
	    		echo $str;
    		}else{
    			echo json_encode(array('id'=>0, 'deport_id'=>0, 'deport_name'=>'', 'name'=>'暂无相关记录'))."\n";
    		}
    	}else{
    		echo json_encode(array('id'=>0, 'deport_id'=>0, 'deport_name'=>'', 'name'=>'参数错误'))."\n";
    	}
    	exit;
    }
    
    public function config_info(){
    	
    }
    
    
}