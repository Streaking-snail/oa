<?php
namespace Home\Controller;
use Common\Common\Controller\AdminBaseController;
class BusinessController extends AdminBaseController {
    
	public $locations = array();
	
	function __construct(){
		parent::__construct();
		$this->locations = array(
				array('is_checked'=>false, 'name'=>'广博集团出差申请单', 'url'=>U('Business/index'))
		);
       $this->assign('loc_name_1', "广博集团出差申请单");
		$this->assign('locations', $this->locations);
	}
	
	public function index(){
		$this->assign("loc_name_2", "列表");
		$search_info['key'] = isset($_POST['key'])?$_POST['key']:'';
		$search_info['number'] = $_POST['number'];
		$search_info['num'] = isset($_POST['num'])?intval($_POST['num']):(isset($_GET['num'])?intval($_GET['num']):10);
		$search_info['deport'] = isset($_POST['deport'])?$_POST['deport']:'';
		$search_info['admin_user'] = isset($_POST['admin_user'])?$_POST['admin_user']:'';
		$search_info['time1'] = isset($_POST['time1'])?$_POST['time1']:'';
		$search_info['time2'] = isset($_POST['time2'])?$_POST['time2']:'';
		$search_info['time3'] = isset($_POST['time3'])?$_POST['time3']:'';
		$search_info['time4'] = isset($_POST['time4'])?$_POST['time4']:'';
		$search_info['show'] = isset($_POST['show'])?$_POST['show']:'';
		$this->assign('search_info', $search_info);
		$Business = D('Business');
		$res = $Business->search_info($search_info);
		$this->assign('is_number', 1);
		$this->assign('application', 1);
		$this->assign('business_search', 1);
		$this->assign('Business', $Business);
		$this->assign('businesses', $res['businesses']);
		$this->assign('show_page', $res['show_page']);
    	$this->display();
    }
    
    public function add_info(){
    	$this->assign("loc_name_2", "添加");
    	$name = !empty($this->user_info['name'])?$this->user_info['name']:$this->user_info['username'];
    	$id = !empty($this->user_info['id'])?$this->user_info['id']:$this->user_info['id'];
    	$deport_id = !empty($this->user_info['deport_id'])?$this->user_info['deport_id']:0;
    	$this->assign("business", array('no'=>time().rand(10, 99), "username"=>$name,"admin_user_id"=>$id,
    					'deport_id'=>$deport_id, 'make_id'=>0, 'input_time'=>time()));
    	$this->display();
    }
    
    public function create_info(){
    	if( isset($_POST['business']) ){
            $_POST['business']['file']=$_FILES['file'];
            $res = D('Business')->create_info($_POST['business']);
    		$notice = $res['msg'];
    		if( $res['status'] ){
    			$this->set_notice(1, $notice);
    			$this->assign('business', $_POST['business']);
    			$this->redirect("Business/index");
                exit;
    		}else{
                $this->set_notice(2, $notice);
    			$this->assign('business', $_POST['business']);
                $this->display("add_info");
                exit;
    		}
    	}else{
    		$notice = "参数错误";
    	}
    	$this->set_notice(2, $notice);
    	$this->redirect('Business/add_info');
    }
    
    public function edit(){
    	$this->assign("loc_name_2", "修改");
    	$business = M('businesses')->alias("a")->join("left join ".C("DB_PREFIX")."admin_user b on b.id=a.admin_user_id")
    	->join("left join ".C("DB_PREFIX")."deport c on c.id=a.deport_id")
    	->field("a.*,ifnull(b.name, b.username) as username,c.name as deport_name")
    	->where("a.id=%d", array($_GET['id']))->find();
    	$this->assign("business", $business);
    	$this->display();
    }
    
    public function update_info(){
    	if( isset($_POST['business']) ){
    		$res = D('Business')->update_info($_POST['business']);
    		$notice = $res['msg'];
    		if( $res['status'] ){
    			$this->set_notice(1, $notice);
    			$this->redirect("Business/index");
    		}
    	}else{
    		$notice = "参数错误";
    	}
    	$this->set_notice(2, $notice);
    	$this->redirect('Business/edit', array('id'=>$_POST['business']['id']));
    }
    
    public function del(){
    	$f = M('business')->where("id=%d", array($_GET['id']))->setField(array('is_del'=>1));
    	if( $f!==false ){
    		$this->set_notice(1, "删除成功");
    	}else{
    		$this->set_notice(2, "删除出错，请重试");
    	}
    	$this->redirect("Business/index");
    }
    
    public function detail(){
    	$this->assign('is_print', 1);
    	$this->assign("loc_name_2", "详情");
    	if( isset($_GET['id']) ){
    		$business = M('businesses')->alias("a")->join("left join ".C("DB_PREFIX")."admin_user b on b.id=a.admin_user_id")
    		->join("left join ".C("DB_PREFIX")."deport c on c.id=a.deport_id")
    		->field("a.*,ifnull(b.name, b.username) as username,c.name as deport_name")
    		->where("a.id=%d", array($_GET['id']))->find();
    		$this->assign("business", $business);
    
                $business_status = M('businesses_status')->alias("a")
                                        ->join("left join ".C("DB_PREFIX")."admin_user b on b.id=a.admin_user_id")
                                        ->field("CONCAT(b.name, '/', b.username) as username, a.content, a.status, a.url_path, a.name, a.create_time")
                                        ->where("a.businesses_id=%d", array($business['id']))
                                        ->order("a.create_time desc")->select();
	    	$this->assign("business_status", $business_status);
    		layout('layouts/detail');
    		$this->display();
    	}else{
    		$this->set_notice(2, "参数错误");
    		$this->redirect("Business/index");
    	}
    }
    
    //审核
    public function check(){
    	if( isset($_POST['check_id']) ){
    		if( D('Business')->is_checked_power($_SESSION['admin_user_id'], $_POST['check_id']) ){
	    		if( isset($_POST['type']) && $_POST['type']=='checked' ){
	    			$status = 1;
	    		}else{
	    			$status = 2;
	    		}
	    		
	    		$process_type_status = D('Business')->get_status($_POST['check_id']);
	    		
	    		$process_type = M('process_types')->where("controller_name='%s'", array(CONTROLLER_NAME))->find();
	    		$pts = M('process_type_status')->where("process_type_id=%d", array($process_type['id']))->order("rank desc, id desc")->find();
	    		
	    		
	    		if( isset($_FILES['file']) && empty($_FILES['file']['name']) ){
	    			include_once SITE_PATH.'/Home/Model/FileUpload.class.php';
	    			$FileUpload = new \FileUpload();
	    			$path = $FileUpload->save_file($_POST['pname'], "/uploadfiles/temporary/".date('Y-m-d')."/");
	    		}
	    		$f = M('businesses_status')->add(array("businesses_id"=>$_POST['check_id'],
	    				"content"=>$_POST['content'], 'create_time'=>time(),
	    				"admin_user_id"=>$_SESSION['admin_user_id'], "status"=>$status,
	    				"process_type_status_id"=>$process_type_status['id'],
	    				"url_path"=>$path, 'name'=>$_POST['attach_name']
	    		));
	    		if( $pts['id']==$process_type_status['id'] ){
	    			$t = M('businesses')->where("id=%d", array($_POST['check_id']))->setField(array("is_over"=>1));
	    		}
	    		$this->set_notice(1, "审核操作成功");
    		}else{
    			$this->set_notice(2, "无权限审核");
    		}
    	}else{
    		$this->set_notice(2, "参数错误");
    	}
    	$this->redirect("Business/index");
    }
    
    public function get_checked_list(){
    layout(false);
    header("Content-type: text/html; charset=utf-8");
    $businesses_status = M('businesses_status')->alias("a")
                                            ->join("left join ".C("DB_PREFIX")."admin_user b on b.id=a.admin_user_id")
                                            ->join("left join ".C("DB_PREFIX")."process_type_status c on c.id=a.process_type_status_id")
                                            ->field("a.*, ifnull(b.name, b.username) as username, c.name as status_name")	
                                            ->where("a.businesses_id=%d", array($_GET['id']))->order("a.create_time asc")->select();
    $this->assign('businesses_status', $businesses_status);
    $this->display("Business/_checked_list");
    exit;
    }
          
}