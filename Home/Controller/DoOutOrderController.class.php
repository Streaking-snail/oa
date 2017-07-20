<?php
namespace Home\Controller;
use Common\Common\Controller\AdminBaseController;
class DoOutOrderController extends AdminBaseController {
    
	public $locations = array();
function __construct(){
		parent::__construct();
		$this->locations = array(
				array('is_checked'=>false, 'name'=>'内销办事处临时外出单', 'url'=>U('DoOutOrder/index'))
		);
        $this->assign('loc_name_1', "内销办事处临时外出单");
		$this->assign('locations', $this->locations);
	}
	
	public function index(){
		$this->assign("loc_name_2", "列表");
		$search_info['key'] = isset($_POST['key'])?$_POST['key']:'';
		$search_info['number'] = $_POST['number'];
		$search_info['num'] = isset($_POST['num'])?intval($_POST['num']):(isset($_GET['num'])?intval($_GET['num']):10);
        $search_info['deport'] = isset($_POST['deport'])?$_POST['deport'] : '';
        $search_info['admin_user'] = isset($_POST['admin_user'])?$_POST['admin_user'] : '';
        $search_info['time1'] = isset($_POST['time1'])?intval(strtotime($_POST['time1'])):'';
        $search_info['time2'] = isset($_POST['time2'])?intval(strtotime($_POST['time2'])):'';
        $search_info['show'] = isset($_POST['show'])?intval($_POST['show']):'0';
		$this->assign('search_info', $search_info);
		$DoOutOrder = D('DoOutOrder');
		$res = $DoOutOrder->search_info($search_info);
		$this->assign('is_number', 1);
		$this->assign('DoOutOrder', $DoOutOrder);
		$this->assign('do_out_orders', $res['do_out_orders']);
//                echo "<pre>";
//                print_r($res['do_out_orders']);exit;
		$this->assign('show_page', $res['show_page']);
		if( $this->user_info['is_admin']==1 || $this->user_info['id']==1 ){
			$this->assign('application', 1);
		}
		
    	$this->display();
    }
    
    public function add_info(){
    	$this->assign("loc_name_2", "添加");
    	$this->assign('do_out_order', array('no'=>time().rand(10,99)));
    	$this->display();
    }
    
    public function create_info(){
    	if( isset($_POST['do_out_order']) ){
//            echo "<pre>";
//            print_r($_POST['do_out_order']);exit;
            $res = D('DoOutOrder')->create_info($_POST['do_out_order']);
    		$notice = $res['msg'];
    		if( $res['status'] ){
    			$this->set_notice(1, $notice);
    			$this->redirect("DoOutOrder/index");
                exit;
    		}else{
                $this->set_notice(2, $notice);
    			$this->assign('do_out_order', $_POST['do_out_order']);
                $this->display("add_info");
                exit;
    		}
    	}else{
    		$notice = "参数错误";
    	}
    	$this->set_notice(2, $notice);
    	$this->redirect('DoOutOrder/add_info');
    }
    
    public function edit(){
    	$this->assign("loc_name_2", "修改");
    	$do_out_order = M('do_out_orders')->where("id=%d", array($_GET['id']))->find();
    	$this->assign("do_out_order", $do_out_order);
    	$this->display();
    }
    
    public function update_info(){
    	if( isset($_POST['do_out_order']) ){
    		$res = D('DoOutOrder')->update_info($_POST['do_out_order']);
    		$notice = $res['msg'];
    		if( $res['status'] ){
    			$this->set_notice(1, $notice);
    			$this->redirect("DoOutOrder/index");
    		}
    	}else{
    		$notice = "参数错误";
    	}
    	$this->set_notice(2, $notice);
    	$this->redirect('DoOutOrder/edit', array('id'=>$_POST['do_out_order']['id']));
    }
    
    public function del(){
    	$f = M('do_out_orders')->where("id=%d", array($_GET['id']))->setField(array('is_del'=>1));
    	if( $f!==false ){
    		$this->set_notice(1, "删除成功");
    	}else{
    		$this->set_notice(2, "删除出错，请重试");
    	}
    	$this->redirect("DoOutOrder/index");
    }
    
    //详情
        public function detail(){
            $this->assign('is_print', 1);
            $this->assign("loc_name_2", "详情");
            if( isset($_GET['id']) ){
                    $do_out_order = M('do_out_orders')->alias("a")->join("left join ".C("DB_PREFIX")."admin_user b on b.id=a.admin_user_id")
                                             ->field("a.*, ifnull(b.name, b.username) as username")
                                             ->where("a.id=%d", array($_GET['id']))->find();
                    $this->assign("do_out_order", $do_out_order);

                    $do_out_order_status = M('do_out_order_status')->alias("a")
                                                            ->join("left join ".C("DB_PREFIX")."admin_user b on b.id=a.admin_user_id")
                                                            ->where("a.do_out_order_id=%d", array($do_out_order['id']))
                                                            ->order("a.create_time desc")->select();
                    $this->assign("do_out_order_status", $do_out_order_status);
                    layout('layouts/detail');
                    $this->display();
            }else{
                    $this->set_notice(2, "参数错误");
                    $this->redirect("DoOutOrder/index");
            }
        }
    
	//审核
    public function check(){
    	if( isset($_POST['check_id']) ){
    		if( isset($_POST['type']) ){
    			$status = $_POST['type']=='checked'?1:2;
    		}else{
    			$status = 1;
    		}
    		if( isset($_FILES['file']) && empty($_FILES['file']['name']) ){
    			include_once SITE_PATH.'/Home/Model/FileUpload.class.php';
    			$FileUpload = new \FileUpload();
    			$path = $FileUpload->save_file($_POST['pname'], "/uploadfiles/do_out_order/".date('Y-m-d')."/");
    		}
    		
    		$f = M('do_out_order_status')->add(array("do_out_order_id"=>$_POST['check_id'],
    				"content"=>$_POST['content'], 'create_time'=>time(),
    				"admin_user_id"=>$_SESSION['admin_user_id'], "status"=>$status,
    				"url_path"=>$path, 'name'=>$_POST['attach_name']
    		));
    		$this->set_notice(1, "审核操作成功");
    	}else{
    		$this->set_notice(2, "参数错误");
    	}
    	$this->redirect("DoOutOrder/index");
    }
       
}