<?php
namespace Home\Controller;
use Common\Common\Controller\AdminBaseController;
class DoBusinessController extends AdminBaseController {
    
	public $locations = array();

	function __construct(){
		parent::__construct();
		$this->locations = array(
				array('is_checked'=>false, 'name'=>'内销办事处出差申请单', 'url'=>U('DoBusiness/index'))
		);
       $this->assign('loc_name_1', "内销办事处出差申请单");
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
		$DoBusiness = D('DoBusiness');
		$res = $DoBusiness->search_info($search_info);
                $this->assign('search_info', $search_info);
		$this->assign('is_number', 1);
		$this->assign('DoBusiness', $DoBusiness);
		$this->assign('dobusinesses', $res['businesses']);
		$this->assign('show_page', $res['show_page']);
		if( $this->user_info['is_admin']==1 || $this->user_info['id']==1 ){
			$this->assign('application', 1);
		}
    	$this->display();
    }
    
    public function add_info(){
    	$this->assign("loc_name_2", "添加");
    	$this->assign('do_business', array('no'=>time().rand(10, 99)));
    	$this->display();
    }
    
    public function create_info(){
    	if( isset($_POST['do_business']) ){
            $res = D('DoBusiness')->create_info($_POST['do_business']);
    		$notice = $res['msg'];
    		if( $res['status'] ){
    			$this->set_notice(1, $notice);
    			$this->redirect("DoBusiness/index");
                exit;
    		}else{
                $this->set_notice(2, $notice);
    			$this->assign('do_business', $_POST['do_business']);
                $this->display("add_info");
                exit;
    		}
    	}else{
    		$notice = "参数错误";
    	}
    	$this->set_notice(2, $notice);
    	$this->redirect('DoBusiness/add_info');
    }
    
    public function edit(){
    	$this->assign("loc_name_2", "修改");
    	$do_business = M('do_businesses')->where("id=%d", array($_GET['id']))->find();
    	$this->assign("do_business", $do_business);
    	$this->display();
    }
    
    public function update_info(){
    	if( isset($_POST['do_business']) ){
    		$res = D('DoBusiness')->update_info($_POST['do_business']);
    		$notice = $res['msg'];
    		if( $res['status'] ){
    			$this->set_notice(1, $notice);
    			$this->redirect("DoBusiness/index");
    		}
    	}else{
    		$notice = "参数错误";
    	}
    	$this->set_notice(2, $notice);
    	$this->redirect('DoBusiness/edit', array('id'=>$_POST['do_business']['id']));
    }
    
    public function detail(){
    	$this->assign('is_print', 1);
    	$this->assign("loc_name_2", "详情");
    	if( isset($_GET['id']) ){
	    	$do_business = M('do_businesses')->alias("a")->join("left join ".C("DB_PREFIX")."admin_user b on b.id=a.admin_user_id")
	    				 ->field("a.*, ifnull(b.name, b.username) as username")
	    				 ->where("a.id=%d", array($_GET['id']))->find();
	    	$this->assign("do_business", $do_business);
	    	
	    	$do_businesses_status = M('do_businesses_status')->alias("a")
	    						->join("left join ".C("DB_PREFIX")."admin_user b on b.id=a.admin_user_id")
	    						->where("a.do_business_id=%d", array($do_business['id']))
	    						->order("a.create_time desc")->select();
	    	$this->assign("do_businesses_status", $do_businesses_status);
	    	layout('layouts/detail');
	    	$this->display();
    	}else{
    		$this->set_notice(2, "参数错误");
    		$this->redirect("DoBusiness/index");
    	}
    }
    
    public function del(){
    	$f = M('do_businesses')->where("id=%d", array($_GET['id']))->setField(array('is_del'=>1));
    	if( $f!==false ){
    		$this->set_notice(1, "删除成功");
    	}else{
    		$this->set_notice(2, "删除出错，请重试");
    	}
    	$this->redirect("DoBusiness/index");
    }
    
     //审核
    public function check(){
    	if( isset($_POST['check_id']) ){
    		if( D('DoBusiness')->is_checked_power($_SESSION['admin_user_id'], $_POST['check_id']) ){
	    		if( isset($_POST['type']) && $_POST['type']=='checked' ){
	    			$status = 1;
	    		}else{
	    			$status = 2;
	    		}
	    		
	    		$process_type_status = D('DoBusiness')->get_status($_POST['check_id']);
	    		
	    		$process_type = M('process_types')->where("controller_name='%s'", array(CONTROLLER_NAME))->find();
	    		$pts = M('process_type_status')->where("process_type_id=%d", array($process_type['id']))->order("rank desc, id desc")->find();
	    		
	    		
	    		if( isset($_FILES['file']) && empty($_FILES['file']['name']) ){
	    			include_once SITE_PATH.'/Home/Model/FileUpload.class.php';
	    			$FileUpload = new \FileUpload();
	    			$path = $FileUpload->save_file($_POST['pname'], "/uploadfiles/temporary/".date('Y-m-d')."/");
	    		}
	    		$f = M('do_businesses_status')->add(array("do_business_id"=>$_POST['check_id'],
	    				"content"=>$_POST['content'], 'create_time'=>time(),
	    				"admin_user_id"=>$_SESSION['admin_user_id'], "status"=>$status,
	    				"process_type_status_id"=>$process_type_status['id'],
	    				"url_path"=>$path, 'name'=>$_POST['attach_name']
	    		));
	    		if( $pts['id']==$process_type_status['id'] ){
	    			$t = M('do_businesses')->where("id=%d", array($_POST['check_id']))->setField(array("is_over"=>1));
	    		}
	    		$this->set_notice(1, "审核操作成功");
    		}else{
    			$this->set_notice(2, "无权限审核");
    		}
    	}else{
    		$this->set_notice(2, "参数错误");
    	}
    	$this->redirect("DoBusiness/index");
    }
    
    public function get_checked_list(){
    layout(false);
    header("Content-type: text/html; charset=utf-8");
    $dobusiness_status = M('do_businesses_status')->alias("a")
                                            ->join("left join ".C("DB_PREFIX")."admin_user b on b.id=a.admin_user_id")
                                            ->join("left join ".C("DB_PREFIX")."process_type_status c on c.id=a.process_type_status_id")
                                            ->field("a.*, ifnull(b.name, b.username) as username, c.name as status_name")	
                                            ->where("a.do_business_id=%d", array($_GET['id']))->order("a.create_time asc")->select();
    $this->assign('dobusiness_status', $dobusiness_status);
    $this->display("DoBusiness/_checked_list");
    exit;
    }
       
}