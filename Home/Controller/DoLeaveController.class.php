<?php
namespace Home\Controller;
use Common\Common\Controller\AdminBaseController;
class DoLeaveController extends AdminBaseController {
    
	public $locations = array();
	
	function __construct(){
		parent::__construct();
		$this->locations = array(
				array('is_checked'=>false, 'name'=>'内销办事处请假单', 'url'=>U('DoLeave/index'))
		);
        $this->assign('loc_name_1', "内销办事处请假单");
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
		$DoLeave = D('DoLeave');
		$res = $DoLeave->search_info($search_info);
		$this->assign('is_number', 1);
		$this->assign('doleaves_search', 1);
		if( $this->user_info['is_admin']==1 || $this->user_info['id']==1 ){
			$this->assign('application', 1);
		}
		$this->assign('DoLeave', $DoLeave);
		$this->assign('do_leaves', $res['do_leaves']);
		$this->assign('show_page', $res['show_page']);
    	$this->display();
    }
    
    public function add_info(){
    	$this->assign("loc_name_2", "添加");
    	$name = !empty($this->user_info['name'])?$this->user_info['name']:$this->user_info['username'];
    	$id = !empty($this->user_info['id'])?$this->user_info['id']:$this->user_info['id'];
    	$deport_id = !empty($this->user_info['deport_id'])?$this->user_info['deport_id']:0;
    	$this->assign("doleave", array('no'=>time().rand(10, 99), "username"=>$name,"admin_user_id"=>$id,
    					'deport_id'=>$deport_id, 'make_id'=>0, 'report_time'=>time()));
    	$this->display();
    }
    
    public function create_info(){
    	if( isset($_POST['doleave']) ){
            $res = D('DoLeave')->create_info($_POST['doleave']);
    		$notice = $res['msg'];
    		if( $res['status'] ){
    			$this->set_notice(1, $notice);
    			$this->redirect("DoLeave/index");
                exit;
    		}else{
                $this->set_notice(2, $notice);
    			$this->assign('do_leave', $_POST['doleave']);
                $this->display("add_info");
                exit;
    		}
    	}else{
    		$notice = "参数错误";
    	}
    	$this->set_notice(2, $notice);
    	$this->redirect('DoLeave/add_info');
    }
    
    public function edit(){
    	$this->assign("loc_name_2", "修改");
    	$do_leave = M('do_leaves')->alias("a")->join("left join ".C("DB_PREFIX")."admin_user b on b.id=a.admin_user_id")
    	->join("left join ".C("DB_PREFIX")."deport c on c.id=a.deport_id")
    	->field("a.*,ifnull(b.name, b.username) as username,c.name as deport_name")
    	->where("a.id=%d", array($_GET['id']))->find();
    	$do_leave['report_time']=time();
    	$this->assign("doleave", $do_leave);
    	$this->display();
    }
    
    public function update_info(){
    	if( isset($_POST['doleave']) ){
    		$res = D('DoLeave')->update_info($_POST['doleave']);
    		$notice = $res['msg'];
    		if( $res['status'] ){
    			$this->set_notice(1, $notice);
    			$this->redirect("DoLeave/index");
    		}
    	}else{
    		$notice = "参数错误";
    	}
    	$this->set_notice(2, $notice);
    	$this->redirect('DoLeave/edit', array('id'=>$_POST['doleave']['id']));
    }
    
    public function detail(){
    	$this->assign('is_print', 1);
    	$this->assign("loc_name_2", "详情");
    	if( isset($_GET['id']) ){
    		$do_leave = M('do_leaves')->alias("a")->join("left join ".C("DB_PREFIX")."admin_user b on b.id=a.admin_user_id")
	    	->join("left join ".C("DB_PREFIX")."deport c on c.id=a.deport_id")
	    	->field("a.*,ifnull(b.name, b.username) as username,c.name as deport_name")
	    	->where("a.id=%d", array($_GET['id']))->find();
    		$this->assign("doleave", $do_leave);
		
                $doleaves_status = M('do_leaves_status')->alias("a")
                                        ->join("left join ".C("DB_PREFIX")."admin_user b on b.id=a.admin_user_id")
                                        ->field("CONCAT(b.name, '/', b.username) as username, a.content, a.status, a.url_path, a.name, a.create_time")
                                        ->where("a.leaves_id=%d", array($do_leave['id']))
                                        ->order("a.create_time desc")->select();
	    	$this->assign("doleaves_status", $doleaves_status);
    		layout('layouts/detail');
    		$this->display();
    	}else{
    		$this->set_notice(2, "参数错误");
    		$this->redirect("DoLeave/index");
    	}
    }
    
    public function del(){
    	$f = M('do_leaves')->where("id=%d", array($_GET['id']))->setField(array('is_del'=>1));
    	if( $f!==false ){
    		$this->set_notice(1, "删除成功");
    	}else{
    		$this->set_notice(2, "删除出错，请重试");
    	}
    	$this->redirect("DoLeave/index");
    }
    
 //审核
    public function check(){
    	if( isset($_POST['check_id']) ){
    		if( D('DoLeave')->is_checked_power($_SESSION['admin_user_id'], $_POST['check_id']) ){
	    		if( isset($_POST['type']) && $_POST['type']=='checked' ){
	    			$status = 1;
	    		}else{
	    			$status = 2;
	    		}
	    		
	    		$process_type_status = D('DoLeave')->get_status($_POST['check_id']);
	    		
	    		$process_type = M('process_types')->where("controller_name='%s'", array(CONTROLLER_NAME))->find();
	    		$pts = M('process_type_status')->where("process_type_id=%d", array($process_type['id']))->order("rank desc, id desc")->find();
	    		
	    		
	    		if( isset($_FILES['file']) && empty($_FILES['file']['name']) ){
	    			include_once SITE_PATH.'/Home/Model/FileUpload.class.php';
	    			$FileUpload = new \FileUpload();
	    			$path = $FileUpload->save_file($_POST['pname'], "/uploadfiles/temporary/".date('Y-m-d')."/");
	    		}
                            
	    		$f = M('do_leaves_status')->add(array("leaves_id"=>$_POST['check_id'],
	    				"content"=>$_POST['content'], 'create_time'=>time(),
	    				"admin_user_id"=>$_SESSION['admin_user_id'], "status"=>$status,
	    				"process_type_status_id"=>$process_type_status['id'],
	    				"url_path"=>$path, 'name'=>$_POST['attach_name']
	    		));
//                            echo  M("do_leaves_status")->getLastSql();
//                            exit;
	    		if( $pts['id']==$process_type_status['id'] ){
	    			$t = M('do_leaves')->where("id=%d", array($_POST['check_id']))->setField(array("is_over"=>1));
	    		}
	    		$this->set_notice(1, "审核操作成功");
    		}else{
    			$this->set_notice(2, "无权限审核");
    		}
    	}else{
    		$this->set_notice(2, "参数错误");
    	}
    	$this->redirect("DoLeave/index");
    }
    
    /*** * 导出Excel */
    function expUser(){//导出Excel
    		include_once SITE_PATH.'/Home/Model/Export.class.php';
    		$titleList = array('单据号','状态','制单部门','制单人','制单日期','备注','开始时间','结束时间');
    		$where = "a.is_del=0";
    		if( !empty($_POST['deport']) ){
    			$where .= " and c.name like '%".$this->str_filter($_POST['deport'])."%'";
    		}
    		if( !empty($_POST['admin_user']) ){
    			$where .= " and b.user_name=".str_filter($_POST['admin_user']);
    		}
    		if( !empty($_POST['time1']) ){
    			$where .= " and a.create_time>=".intval(strtotime($_POST['time1']));
    		}
    		if( !empty($_POST['time2']) ){
    			$where .= " and a.create_time<=".intval(strtotime($_POST['time2']));
    		}
    		if( !empty($_POST['time3']) ){
    			$where .= " and a.start_time>=".intval(strtotime($_POST['time3']));
    		}
    		if( !empty($_POST['time4']) ){
    			$where .= " and a.end_time<=".intval(strtotime($_POST['time4']));
    		}

    		 
    		$arrs = M('do_leaves')->alias('a')->join("left join ".C("DB_PREFIX")."admin_user b on b.id=a.admin_user_id")
	    			->join("left join ".C("DB_PREFIX")."deport c on c.id=a.deport_id")
	    			->join("left join ".C("DB_PREFIX")."do_leaves_status d on d.leaves_id=a.id")
    				->field("a.no, d.status,c.name as deport_name,b.name as user_name, a.create_time, ".
    						"a.content, a.start_time, a.end_time")
    						->where($where)->group('a.id')->order("a.create_time desc")->select();
    		
    		$xlsData=array();
    		foreach( $arrs as $key=>$value){
    				$xlsData[$key]=$value;
    				$xlsData[$key]['start_time']=date("Y-m-d  H:m:s", $xlsData[$key]['start_time']);
    				$xlsData[$key]['end_time']=date("Y-m-d  H:m:s", $xlsData[$key]['end_time']);
    				$xlsData[$key]['status']='未审核 ';
	    			switch($value['status']){
	    			case 0: $xlsData[$key]['status']='未审核 ';
	    			break;
	    			case 1: $xlsData[$key]['status']='审核通过';
	    			break;
	    			default :$xlsData[$key]['status']='审核不通过 ';
	    			break;
    			}
    		}
    		$export = new \Export();
    		$export->export_csv($xlsData, $titleList);
    }
    
    public function get_checked_list(){
    	layout(false);
    	header("Content-type: text/html; charset=utf-8");
    	$leaves_status = M('do_leaves_status')->alias("a")
    						->join("left join ".C("DB_PREFIX")."admin_user b on b.id=a.admin_user_id")
    						->join("left join ".C("DB_PREFIX")."process_type_status c on c.id=a.process_type_status_id")
    						->field("a.*, ifnull(b.name, b.username) as username, c.name as status_name")	
    						->where("a.leaves_id=%d", array($_GET['id']))->order("a.create_time asc")->select();
    	$this->assign('leaves_status', $leaves_status);
    	$this->display("Leave/_checked_list");
    	exit;
    }
    
}