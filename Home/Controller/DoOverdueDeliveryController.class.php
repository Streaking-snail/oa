<?php
namespace Home\Controller;

use Common\Common\Controller\AdminBaseController;

class DoOverdueDeliveryController extends AdminBaseController
{

    public $locations = array();

    function __construct()
    {
        parent::__construct();
        $this->locations = array(
            array('is_checked' => false, 'name' => '超额或超期发货申请单', 'url' => U('DoOverdueDelivery/index'))
        );
        $this->assign('locations', $this->locations);
        $this->assign('loc_name_1', '超额或超期发货申请单');
    }

    public function index()
    {
        $this->assign('loc_name_2', '超额或超期申请单列表');
        $search_info['num'] = isset($_POST['num']) ? intval($_POST['num']) : intval($_GET['num']);
        $search_info['key'] = isset($_POST['key']) ? $_POST['key'] : '';
        $search_info['deport'] = isset($_POST['deport'])?$_POST['deport'] : '';
        $search_info['admin_user'] = isset($_POST['admin_user'])?$_POST['admin_user'] : '';
        $search_info['time1'] = isset($_POST['time1'])?intval(strtotime($_POST['time1'])):'';
        $search_info['time2'] = isset($_POST['time2'])?intval(strtotime($_POST['time2'])):'';
        $search_info['show'] = isset($_POST['show'])?intval($_POST['show']):'0';
        $this->assign('search_info', $search_info);
        $res = D('DoOverdueDelivery')->search_info($search_info);
        $this->assign('overdue_list', $res['do_overdue_list']);
        $this->assign('show_page', $res['show_page']);
        $this->assign('Deport', D('Deport'));
   		if( $this->user_info['is_admin']==1 || $this->user_info['id']==1 ){
			$this->assign('application', 1);
		}
        $this->show();
    }

    public function add_info()
    {
        $this->assign('loc_name_2', '添加超额或超期申请单');
        $this->assign('overdue',array('no'=>time().rand(10,99)));
        $this->show();
    }

    public function create_info()
    {
        if (isset($_POST['overdue'])) {
            $_POST['overdue']['admin_user_id'] = $this->admin_user_id;
            $_POST['overdue']['office_id'] = $this->user_info['deport_id'];
            $res = D('DoOverdueDelivery')->create_info($_POST['overdue']);
            $notice = $res['msg'];
            if ($res['status']) {
                $this->set_notice(1, $notice);
                $this->redirect("DoOverdueDelivery/index");
                exit;
            } else {
                $this->set_notice(2, $notice);
                $this->assign('overdue', $_POST['overdue']);
                $this->display("add_info");
                exit;
            }
        } else {
            $notice = "参数错误";
        }
        $this->set_notice(2, $notice);
        $this->redirect('DoOverdueDelivery/add_info');
    }

    public function edit()
    {
        $this->assign('loc_name_2', '修改超额或超期申请单');
        $overdue = M('do_overdue_deliveries')->where('id=%d', array($_GET['id']))->find();
        $this->assign('overdue', $overdue);
        $this->show();
    }

    public function update_info()
    {
        if (isset($_POST['overdue'])) {
            $_POST['overdue']['admin_user_id'] = $this->admin_user_id; // 操作人ID
//            $_POST['overdue']['office_id'] = $this->user_info['deport_id'];
            $res = D('DoOverdueDelivery')->update_info($_POST['overdue']);
            $notice = $res['msg'];
            if ($res['status']) {
                $this->set_notice(1, $notice);
                $this->redirect("DoOverdueDelivery/index");
            }
        } else {
            $notice = "参数错误";
        }
        $this->set_notice(2, $notice);
        $this->redirect('DoOverdueDelivery/edit', array('id' => $_POST['overdue']['id']));
    }

    public function detail()
    {
        $this->assign('is_print', 1);
        $this->assign("loc_name_2", "详情");
        if (isset($_GET['id'])) {
            $overdue = M('do_overdue_deliveries')->where('id=%d', array($_GET['id']))->find();
            $this->assign('overdue', $overdue);
            layout('layouts/detail');
            $this->display();
        } else {
            $this->set_notice(2, "参数错误");
            $this->redirect("DoOverdueDelivery/index");
        }
    }

    public function del()
    {
        if (intval($_REQUEST['id']) > 0) {
            $f = M('do_overdue_deliveries')->where('id=%d', array(intval($_REQUEST['id'])))->setField(array('is_del' => 1));
            if ($f !== false) {
                $this->set_notice(1, 'ok');
            } else {
                $this->set_notice(2, '删除失败');
            }
        } else {
            $this->set_notice(2, '参数有误');
        }
        $this->redirect('DoOverdueDelivery/index');
    }

    public function get_checked_list()
    {
        layout(false);
        header("Content-type: text/html; charset=utf-8");
        $data_status = M('do_overdue_delivery_status')->alias("a")->join("left join " . C("DB_PREFIX") . "admin_user b on b.id=a.admin_user_id")
            ->field("a.*, ifnull(b.name, b.username) as username")
            ->where("a.do_overdue_delivery_id=%d", array($_GET['id']))->order("a.create_time asc")->select();
        $this->assign('data_status', $data_status);
        $this->display("DoOverdueDelivery/_checked_list");
        exit;
    }

    //审核
    public function check()
    {
        if (isset($_POST['check_id'])) {
            if (isset($_POST['type'])) {
                $status = $_POST['type'] == 'checked' ? 1 : 2;
            } else {
                $status = 1;
            }
            $controller = strtolower(CONTROLLER_NAME);
            if (isset($_FILES['file']) && !empty($_FILES['file']['name'])) {
                include_once SITE_PATH . '/Home/Model/FileUpload.class.php';
                $FileUpload = new \FileUpload();
                $path = $FileUpload->save_file($_FILES['file'], "/uploadfiles/$controller/" . date('Y-m-d') . "/");
            }
            $f = M('do_overdue_delivery_status')->add(array("do_overdue_delivery_id" => $_POST['check_id'],
                "content" => $_POST['content'], 'create_time' => time(),
                "admin_user_id" => $_SESSION['admin_user_id'], "status" => $status,
                "url_path" => isset($path)?$path:'', 'name' => trim($_POST['attach_name'])
            ));
            if ($f !== false) {
                $this->set_notice(1, "审核操作成功");
            } else {
                $this->set_notice(2, '审核操作失败,请重试');
            }
        } else {
            $this->set_notice(2, "参数错误");
        }
        $this->redirect("index");
    }
}