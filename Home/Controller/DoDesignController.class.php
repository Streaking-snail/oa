<?php
namespace Home\Controller;
use Common\Common\Controller\AdminBaseController;
class DoDesignController extends AdminBaseController {
    
	public $locations = array();
	
	function __construct(){
		parent::__construct();
		$this->locations = array(
				array('is_checked'=>false, 'name'=>'内销广告设计制作申请表', 'url'=>U('DoDesign/index'))
		);
		$this->assign('loc_name_1', "内销广告设计制作申请表");
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
		$DoDesign = D('DoDesign');
		$res = $DoDesign->search_info($search_info);
		$this->assign('is_number', 1);
		$this->assign('DoDesign', $DoDesign);
		$this->assign('do_designs', $res['do_designs']);
		$this->assign('show_page', $res['show_page']);
		if( $this->user_info['is_admin']==1 || $this->user_info['id']==1 ){
			$this->assign('application', 1);
		}
		$this->display();
	}
	
	public function add_info(){
		$this->assign("loc_name_2", "添加");
		$this->assign('do_design', array('no'=>time().rand(10, 99)));
		$this->display();
	}
	
	public function create_info(){
		if( isset($_POST['do_design']) ){
                    if( isset($_POST['do_design_items']) ){
                        $items = $_POST['do_design_items'];
                    }else{
                        $items = array();
                    }
			$res = D('DoDesign')->create_info($_POST['do_design'],$items);
			$notice = $res['msg'];
			if( $res['status'] ){
				$this->set_notice(1, $notice);
				$this->redirect("DoDesign/index");
				exit;
			}else{
				$this->set_notice(2, $notice);
				$this->assign('do_design', $_POST['do_design']);
				$this->display("add_info");
				exit;
			}
		}else{
			$notice = "参数错误";
		}
		$this->set_notice(2, $notice);
		$this->redirect('DoDesign/add_info');
	}
	
	public function edit(){
		$this->assign("loc_name_2", "修改");
		$do_design = M('do_designs')->where("id=%d", array($_GET['id']))->find();
                $do_design_item = M('do_design_items')->where("do_design_id=%d", $do_design['id'])->select();
                $items_num = count($do_design_item)-1;
                $this->assign('items_num', $items_num);
                $this->assign("do_design_item", $do_design_item);
		$this->assign("do_design", $do_design);
		$this->display();
	}
	
	public function update_info(){
		if( isset($_POST['do_design']) ){
                    if( isset($_POST['do_design_items']) ){
                        $items = $_POST['do_design_items'];
                    }else{
                        $items = array();
                    }
			$res = D('DoDesign')->update_info($_POST['do_design'],$items);
			$notice = $res['msg'];
			if( $res['status'] ){
				$this->set_notice(1, $notice);
				$this->redirect("DoDesign/index");
			}
		}else{
			$notice = "参数错误";
		}
		$this->set_notice(2, $notice);
		$this->redirect('DoDesign/edit', array('id'=>$_POST['do_design']['id']));
	}
	
	public function del(){
		$f = M('do_designs')->where("id=%d", array($_GET['id']))->setField(array('is_del'=>1));
		if( $f!==false ){
			$this->set_notice(1, "删除成功");
		}else{
			$this->set_notice(2, "删除出错，请重试");
		}
		$this->redirect("DoDesign/index");
	}
        
	public function detail(){
            $this->assign('is_print', 1);
            $this->assign("loc_name_2", "详情");
            if( isset($_GET['id']) ){
                    $do_design = M('do_designs')->alias("a")->join("left join ".C("DB_PREFIX")."admin_user b on b.id=a.admin_user_id")
                                             ->field("a.*, ifnull(b.name, b.username) as username")
                                             ->where("a.id=%d", array($_GET['id']))->find();
                    $this->assign("do_design", $do_design);
                    $do_design_items = M('do_design_items')->where("do_design_id=%d", array($_GET['id']))->select();
                    $items_num = count($do_design_items)-1;
                    $this->assign('items_num',$items_num);
                    $this->assign("do_design_items",$do_design_items);

                    $do_design_status = M('do_design_status')->alias("a")
                                                            ->join("left join ".C("DB_PREFIX")."admin_user b on b.id=a.admin_user_id")
                                                            ->where("a.do_design_id=%d", array($do_design['id']))
                                                            ->order("a.create_time desc")->select();
                    $this->assign("do_design_status", $do_design_status);
                    $office_id = M('deport')->where("id=%d", array($do_design['office_id']))->find();
                    $this->assign("office_id", $office_id);
                    layout('layouts/detail');
                    $this->display();
            }else{
                    $this->set_notice(2, "参数错误");
                    $this->redirect("DoDesign/index");
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
				$path = $FileUpload->save_file($_POST['pname'], "/uploadfiles/do_design/".date('Y-m-d')."/");
			}
	
			$f = M('do_design_status')->add(array("do_design_id"=>$_POST['check_id'],
					"content"=>$_POST['content'], 'create_time'=>time(),
					"admin_user_id"=>$_SESSION['admin_user_id'], "status"=>$status,
					"url_path"=>$path, 'name'=>$_POST['attach_name']
			));
			$this->set_notice(1, "审核操作成功");
		}else{
			$this->set_notice(2, "参数错误");
		}
		$this->redirect("DoDesign/index");
	}
       
}