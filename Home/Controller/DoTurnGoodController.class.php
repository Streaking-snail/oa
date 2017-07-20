<?php
namespace Home\Controller;
use Common\Common\Controller\AdminBaseController;
class DoTurnGoodController extends AdminBaseController {
    
	public $locations = array();
	
	function __construct(){
		parent::__construct();
		$this->locations = array(
				array('is_checked'=>false, 'name'=>'内销办事处调货报告', 'url'=>U('DoTurnGood/index'))
		);
       $this->assign('loc_name_1', "内销办事处调货报告");
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
		$DoTurnGood = D('DoTurnGood');
		$res = $DoTurnGood->search_info($search_info);
		$this->assign('is_number', 1);
		$this->assign('DoTurnGood', $DoTurnGood);
		$this->assign('do_turn_goods', $res['do_turn_goods']);
		$this->assign('show_page', $res['show_page']);
		if( $this->user_info['is_admin']==1 || $this->user_info['id']==1 ){
			$this->assign('application', 1);
		}
    	$this->display();
    }
    
        public function add_info(){
            $this->assign("loc_name_2", "添加");
            $this->assign('do_turn_good', array());
            $office_id = M('deport')->select();
            $this->assign('office_id', $office_id);
            $this->display();
        }
    
        public function create_info(){
            if( isset( $_POST['do_turn_good']) ){
                if( isset($_POST['do_turn_good_items']) ){
                    $items = $_POST['do_turn_good_items'];
                }else{
                    $items = array();
                }
//                echo "<pre>";
//                print_r($_POST['do_turn_good_items']);exit;
                $res = D('DoTurnGood')->create_info($_POST['do_turn_good'],$items);
                    $notice = $res['msg'];
                    if( $res['status'] ){
                            $this->set_notice(1, $notice);
                            $this->redirect("DoTurnGood/index");
                    exit;
                    }else{
                    $this->set_notice(2, $notice);
                            $this->assign('do_turn_good', $_POST['do_turn_good']);
                    $this->display("add_info");
                    exit;
                    }
            }else{
                    $notice = "参数错误";
            }
            $this->set_notice(2, $notice);
            $this->redirect('DoTurnGood/add_info');
        }

        public function edit(){
            $this->assign("loc_name_2", "修改");
            $do_turn_good = M('do_turn_goods')->where("id=%d", array($_GET['id']))->find();
            $do_turn_good_item = M('do_turn_good_items')->where("do_turn_good_id=%d",array($_GET['id']))->select();
            $office_id = M('deport')->select();
            $this->assign('office_id',$office_id);
            $this->assign("do_turn_good_item", $do_turn_good_item);
            $this->assign("do_turn_good", $do_turn_good);
            $this->display();
        }

        public function update_info(){
            if( isset($_POST['do_turn_good']) ){
                if( isset($_POST['do_turn_good_items']) ){
                    $items = $_POST['do_turn_good_items'];
                }else{
                    $items = array();
                }
                    $res = D('DoTurnGood')->update_info($_POST['do_turn_good'],$items);
                    $notice = $res['msg'];
                    if( $res['status'] ){
                            $this->set_notice(1, $notice);
                            $this->redirect("DoTurnGood/index");
                    }
            }else{
                    $notice = "参数错误";
            }
            $this->set_notice(2, $notice);
            $this->redirect('DoTurnGood/edit', array('id'=>$_POST['do_turn_good']['id']));
        }
        
        public function detail(){
            $this->assign('is_print', 1);
            $this->assign("loc_name_2", "详情");
            if( isset($_GET['id']) ){
                    $do_turn_good = M('do_turn_goods')->alias("a")->join("left join ".C("DB_PREFIX")."admin_user b on b.id=a.admin_user_id")
                                             ->field("a.*, ifnull(b.name, b.username) as username")
                                             ->where("a.id=%d", array($_GET['id']))->find();
                    $this->assign("do_turn_good", $do_turn_good);
                    $do_turn_good_items = M('do_turn_good_items')->where("do_turn_good_id=%d", array($_GET['id']))->select();
                    $this->assign("do_turn_good_items",$do_turn_good_items);

                    $do_turn_good_status = M('do_turn_good_status')->alias("a")
                                                            ->join("left join ".C("DB_PREFIX")."admin_user b on b.id=a.admin_user_id")
                                                            ->where("a.do_turn_good_id=%d", array($do_turn_good['id']))
                                                            ->order("a.create_time desc")->select();
                    $this->assign("do_turn_good_status", $do_turn_good_status);
                    layout('layouts/detail');
                    $this->display();
            }else{
                    $this->set_notice(2, "参数错误");
                    $this->redirect("DoTurnGood/index");
            }
        }

        public function del(){
            $f = M('do_turn_goods')->where("id=%d", array($_GET['id']))->setField(array('is_del'=>1));
            $f = M('do_turn_good_items')->where("do_turn_good_id=%d", array($_GET['id']))->setField(array('is_del'=>1));
            if( $f!==false ){
                    $this->set_notice(1, "删除成功");
            }else{
                    $this->set_notice(2, "删除出错，请重试");
            }
            $this->redirect("DoTurnGood/index");
        }

    //审核
    public function check(){
    	if( isset($_POST['check_id']) ){
    		if( D('DoTurnGood')->is_checked_power($_SESSION['admin_user_id'], $_POST['check_id']) ){
	    		if( isset($_POST['type']) && $_POST['type']=='checked' ){
	    			$status = 1;
	    		}else{
	    			$status = 2;
	    		}
	    		
	    		$process_type_status = D('DoTurnGood')->get_status($_POST['check_id']);
	    		
	    		$process_type = M('process_types')->where("controller_name='%s'", array(CONTROLLER_NAME))->find();
	    		$pts = M('process_type_status')->where("process_type_id=%d", array($process_type['id']))->order("rank desc, id desc")->find();
	    		
	    		
	    		if( isset($_FILES['file']) && empty($_FILES['file']['name']) ){
	    			include_once SITE_PATH.'/Home/Model/FileUpload.class.php';
	    			$FileUpload = new \FileUpload();
	    			$path = $FileUpload->save_file($_POST['pname'], "/uploadfiles/temporary/".date('Y-m-d')."/");
	    		}
	    		$f = M('do_turn_good_status')->add(array("do_turn_good_id"=>$_POST['check_id'],
	    				"content"=>$_POST['content'], 'create_time'=>time(),
	    				"admin_user_id"=>$_SESSION['admin_user_id'], "status"=>$status,
	    				"process_type_status_id"=>$process_type_status['id'],
	    				"url_path"=>$path, 'name'=>$_POST['attach_name']
	    		));
	    		if( $pts['id']==$process_type_status['id'] ){
	    			$t = M('do_turn_goods')->where("id=%d", array($_POST['check_id']))->setField(array("is_over"=>1));
	    		}
	    		$this->set_notice(1, "审核操作成功");
    		}else{
    			$this->set_notice(2, "无权限审核");
    		}
    	}else{
    		$this->set_notice(2, "参数错误");
    	}
    	$this->redirect("DoTurnGood/index");
    }
    
    public function get_checked_list(){
    layout(false);
    header("Content-type: text/html; charset=utf-8");
    $do_turn_good_status = M('do_turn_good_status')->alias("a")
                                            ->join("left join ".C("DB_PREFIX")."admin_user b on b.id=a.admin_user_id")
                                            ->join("left join ".C("DB_PREFIX")."process_type_status c on c.id=a.process_type_status_id")
                                            ->field("a.*, ifnull(b.name, b.username) as username, c.name as status_name")	
                                            ->where("a.do_turn_good_id=%d", array($_GET['id']))->order("a.create_time asc")->select();
    $this->assign('do_turn_good_status', $do_turn_good_status);
    $this->display("DoTurnGood/_checked_list");
    exit;
    }
       
}