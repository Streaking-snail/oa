<?php
namespace Home\Controller;
use Common\Common\Controller\AdminBaseController;
class TemporaryController extends AdminBaseController {
    
	public $locations = array();
	
	function __construct(){
		parent::__construct();
		$this->locations = array(
				array('is_checked'=>false, 'name'=>'公司临时审批表', 'url'=>U('Temporary/index'))
		);
        $this->category_id = isset($_POST['category_id'])?intval($_POST['category_id']):(isset($_GET['category_id'])?$_GET['category_id']:0);
        $this->sub_category_id = isset($_POST['sub_category_id'])?intval($_POST['sub_category_id']):isset($_GET['sub_category_id'])?$_GET['sub_category_id']:0;
        $this->classification_id = isset($_POST['classification_id'])?intval($_POST['classification_id']):isset($_GET['classification_id'])?$_GET['classification_id']:0;
        $this->assign('loc_name_1', "公司临时审批表");
		$this->assign('locations', $this->locations);
	}
	
	public function index(){
		$this->assign("loc_name_2", "公司临时审批列表");
		$search_info['key'] = isset($_POST['key'])?$_POST['key']:'';
		$search_info['number'] = $_POST['number'];
		$search_info['num'] = isset($_POST['num'])?intval($_POST['num']):(isset($_GET['num'])?intval($_GET['num']):10);
		$search_info['deport'] = isset($_POST['deport'])?$_POST['deport']:'';
		$search_info['admin_user'] = isset($_POST['admin_user'])?$_POST['admin_user']:'';
		$search_info['time1'] = isset($_POST['time1'])?$_POST['time1']:'';
		$search_info['time2'] = isset($_POST['time2'])?$_POST['time2']:'';
		$search_info['show'] = isset($_POST['show'])?$_POST['show']:'';
		$this->assign('search_info', $search_info);
		if( $this->user_info['is_admin']==1 || $this->user_info['id']==1 ){
			$this->assign('application', 1);
		}
		$Temoraries = D("Temporaries");
		$this->assign('Temoraries', $Temoraries);
		$res = $Temoraries->search_info($search_info);
		$this->assign('temporaries', $res['temporaries']);
		$this->assign('show_page', $res['show_page']);
    	$this->display();
    }
    
    public function add_info(){
    	$this->assign("loc_name_2", "添加");
    	$name = !empty($this->user_info['name'])?$this->user_info['name']:$this->user_info['username'];
    	$this->assign("temporary", array('no'=>time().rand(10, 99), "username"=>$name,
    					'deport_id'=>0, 'make_id'=>0, 'report_time'=>time()));
    	$this->display();
    }
    
    public function create_info(){
    	if( isset($_POST['temporary']) ){
    		$_POST['temporary']['user_name'] = $_POST['user_name'];
    		$_POST['temporary']['deport_name'] = $_POST['deport_name'];
            $res = D('Temporaries')->create_info($_POST['temporary']);
    		$notice = $res['msg'];
    		if( $res['status'] ){
    			$this->set_notice(1, $notice);
    			$this->redirect("Temporary/index");
    		}else{
                $this->set_notice(2, $notice);
    			$this->assign('temporary', $_POST['temporary']);
                $this->display("add_info");
                exit;
    		}
    	}else{
    		$notice = "参数错误";
    	}
    	$this->set_notice(2, $notice);
    	$this->redirect('Temporary/add_info');
    }
    
    public function edit(){
    	$this->assign("loc_name_2", "修改");
    	$temporary = M('temporaries')->alias("a")->join("left join ".C("DB_PREFIX")."admin_user b on b.id=a.admin_user_id")
    				 ->field("a.*,ifnull(b.name, b.username) as username")
    				 ->where("a.id=%d", array($_GET['id']))->find();
    	$this->assign("temporary", $temporary);
    	$this->display();
    }
    
    public function update_info(){
    	if( isset($_POST['temporary']) ){
    		$_POST['temporary']['deport_name'] = $_POST['deport_name'];
    		$_POST['temporary']['user_name'] = $_POST['user_name'];
    		$res = D('Temporaries')->update_info($_POST['temporary']);
    		$notice = $res['msg'];
    		if( $res['status'] ){
    			$this->set_notice(1, $notice);
    			$this->redirect("Temporary/index");
    		}
    	}else{
    		$notice = "参数错误";
    	}
    	$this->set_notice(2, $notice);
    	$this->redirect('Temporary/edit', array('id'=>$_POST['product']['id']));
    }
    
    public function detail(){
    	$this->assign('is_print', 1);
    	$this->assign("loc_name_2", "详情");
    	if( isset($_GET['id']) ){
	    	$temporary = M('temporaries')->alias("a")->join("left join ".C("DB_PREFIX")."admin_user b on b.id=a.admin_user_id")
	    				 ->field("a.*, ifnull(b.name, b.username) as username")
	    				 ->where("a.id=%d", array($_GET['id']))->find();
	    	$this->assign("temporary", $temporary);
	    	
	    	$temporary_status = M('temporaries_status')->alias("a")
	    						->join("left join ".C("DB_PREFIX")."admin_user b on b.id=a.admin_user_id")
	    						->field("CONCAT(b.name, '/', b.username) as username, a.content, a.status, a.url_path, a.name, a.create_time")
	    						->where("a.temporary_id=%d", array($temporary['id']))
	    						->order("a.create_time desc")->select();
	    	$this->assign("temporary_status", $temporary_status);
	    	layout('layouts/detail');
	    	$this->display();
    	}else{
    		$this->set_notice(2, "参数错误");
    		$this->redirect("Temporary/index");
    	}
    }
    
    public function del(){
    	$f = M('temporaries')->where("id=%d", array($_GET['id']))->setField(array('is_del'=>1));
    	if( $f!==false ){
    		$this->set_notice(1, "删除成功");
    	}else{
    		$this->set_notice(2, "删除出错，请重试");
    	}
    	$this->redirect("Temporary/index");
    }
    
    public function upload_file(){
    	include_once SITE_PATH.'/Home/Model/FileUpload.class.php';
    	$FileUpload = new \FileUpload();
    	$path = $FileUpload->save_file($_POST['pname'], "/uploadfiles/temporary/".date('Y-m-d')."/");
    	if( $id>0 ){
    		echo "yes";
    	}else{
    		echo "no";
    	}
    	exit;
    }
    
    public function get_checked_list(){
    	layout(false);
    	header("Content-type: text/html; charset=utf-8");
    	$temporary_status = M('temporaries_status')->alias("a")
    						->join("left join ".C("DB_PREFIX")."admin_user b on b.id=a.admin_user_id")
    						->join("left join ".C("DB_PREFIX")."process_type_status c on c.id=a.process_type_status_id")
    						->field("a.*, ifnull(b.name, b.username) as username, c.name as status_name")	
    						->where("a.temporary_id=%d", array($_GET['id']))->order("a.create_time asc")->select();
    	$this->assign('temporary_status', $temporary_status);
    	$this->display("Temporary/_checked_list");
    	exit;
    }
    
    //审核
    public function check(){
    	if( isset($_POST['check_id']) ){
    		if( D('Temporaries')->is_checked_power($_SESSION['admin_user_id'], $_POST['check_id']) ){
	    		if( isset($_POST['type']) && $_POST['type']=='checked' ){
	    			$status = 1;
	    		}else{
	    			$status = 2;
	    		}
	    		
	    		$process_type_status = D('Temporaries')->get_status($_POST['check_id']);
	    		
	    		$process_type = M('process_types')->where("controller_name='%s'", array(CONTROLLER_NAME))->find();
	    		$pts = M('process_type_status')->where("process_type_id=%d", array($process_type['id']))->order("rank desc, id desc")->find();
	    		
	    		
	    		if( isset($_FILES['file']) && empty($_FILES['file']['name']) ){
	    			include_once SITE_PATH.'/Home/Model/FileUpload.class.php';
	    			$FileUpload = new \FileUpload();
	    			$path = $FileUpload->save_file($_POST['pname'], "/uploadfiles/temporary/".date('Y-m-d')."/");
	    		}
	    		$f = M('temporaries_status')->add(array("temporary_id"=>$_POST['check_id'],
	    				"content"=>$_POST['content'], 'create_time'=>time(),
	    				"admin_user_id"=>$_SESSION['admin_user_id'], "status"=>$status,
	    				"process_type_status_id"=>$process_type_status['id'],
	    				"url_path"=>$path, 'name'=>$_POST['attach_name']
	    		));
	    		if( $pts['id']==$process_type_status['id'] ){
	    			$t = M('temporaries')->where("id=%d", array($_POST['check_id']))->setField(array("is_over"=>1));
	    		}
	    		$this->set_notice(1, "审核操作成功");
    		}else{
    			$this->set_notice(2, "无权限审核");
    		}
    	}else{
    		$this->set_notice(2, "参数错误");
    	}
    	$this->redirect("Temporary/index");
    }
   
}