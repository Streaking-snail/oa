<?php
namespace Home\Controller;

use Common\Common\Controller\AdminBaseController;

class DoCustomerReturnController extends AdminBaseController
{

    public $locations = array();

    function __construct()
    {
        parent::__construct();
        $this->locations = array(
            array('is_checked' => false, 'name' => '内销市场客户退货申请单', 'url' => U('DoCustomerReturn/index'))
        );
        $this->assign('loc_name_1', "内销市场客户退货申请单");
        $this->assign('locations', $this->locations);
    }

    public function index()
    {
        $this->assign("loc_name_2", "列表");
        $search_info['key'] = isset($_POST['key']) ? $_POST['key'] : '';
        $search_info['number'] = $_POST['number'];
        $search_info['num'] = isset($_POST['num']) ? intval($_POST['num']) : (isset($_GET['num']) ? intval($_GET['num']) : 10);
        $search_info['deport'] = isset($_POST['deport'])?$_POST['deport'] : '';
        $search_info['admin_user'] = isset($_POST['admin_user'])?$_POST['admin_user'] : '';
        $search_info['time1'] = isset($_POST['time1'])?intval(strtotime($_POST['time1'])):'';
        $search_info['time2'] = isset($_POST['time2'])?intval(strtotime($_POST['time2'])):'';
        $search_info['show'] = isset($_POST['show'])?intval($_POST['show']):'0';
        $DoCustomerReturn = D('DoCustomerReturn');
        $res = $DoCustomerReturn->search_info($search_info);
        $this->assign('search_info', $search_info);
        $this->assign('is_number', 1);
        $this->assign('DoCustomerReturn', $DoCustomerReturn);
        $this->assign('do_customer_returns', $res['data']);
        $this->assign('show_page', $res['show_page']);
    	if( $this->user_info['is_admin']==1 || $this->user_info['id']==1 ){
			$this->assign('application', 1);
		}
        $this->display();
    }

    public function add_info()
    {
        $this->assign("loc_name_2", "添加");
        $this->assign('return', array('no'=>time().rand(10, 99)));
        $products = D('Product')->get_products_list();
        $this->assign("products", $products);
        $this->display();
    }

    public function create_info()
    {
        if (isset($_POST['return'])) {
            $_POST['return']['office_id'] = $this->user_info['deport_id'];
            $_POST['return']['admin_user_id'] = $this->admin_user_id;
            $res = D('DoCustomerReturn')->create_info($_POST['return']);
            $notice = $res['msg'];
            if ($res['status']) {
                $this->set_notice(1, $notice);
                $this->redirect("DoCustomerReturn/index");
                exit;
            } else {
                $this->set_notice(2, $notice);
                $this->assign('do_customer_return', $_POST['do_customer_return']);
                $this->display("add_info");
                exit;
            }
        } else {
            $notice = "参数错误";
        }
        $this->set_notice(2, $notice);
        $this->redirect('DoCustomerReturn/add_info');
    }

    public function edit()
    {
        $this->assign("loc_name_2", "修改");
        $return = M('do_customer_returns')->where("id=%d", array($_GET['id']))->find();
        $return_items = M('do_customer_return_items')
            ->where('do_customer_return_id=%d', array($_GET['id']))->select();
        $this->assign('id', intval($_GET['id']));
        $this->assign('return', $return);
        $this->assign('items', $return_items);
        $this->display();
    }

    public function update_info()
    {
        if (isset($_POST['return'])) {
            $res = D('DoCustomerReturn')->update_info($_POST['return']);
            $notice = $res['msg'];
            if ($res['status']) {
                $this->set_notice(1, $notice);
                $this->redirect("DoCustomerReturn/index");
            }
        } else {
            $notice = "参数错误";
        }
        $this->set_notice(2, $notice);
        $this->redirect('DoCustomerReturn/edit', array('id' => $_POST['return']['id']));
    }

    public function del()
    {
        $f = M('do_customer_returns')->where("id=%d", array($_GET['id']))->setField(array('is_del' => 1));
        if ($f !== false) {
            $this->set_notice(1, "删除成功");
        } else {
            $this->set_notice(2, "删除出错，请重试");
        }
        $this->redirect("DoCustomerReturn/index");
    }

    public function get_checked_list()
    {
        layout(false);
        header("Content-type: text/html; charset=utf-8");
        $data_status = M('do_customer_return_status')->alias("a")->join("left join " . C("DB_PREFIX") . "admin_user b on b.id=a.admin_user_id")
            ->field("a.*, ifnull(b.name, b.username) as username")
            ->where("a.do_customer_return_id=%d", array($_GET['id']))->order("a.create_time asc")->select();
        $this->assign('data_status', $data_status);
        $this->display("DoCustomerReturn/_checked_list");
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
            if (isset($_FILES['file']) && empty($_FILES['file']['name'])) {
                include_once SITE_PATH . '/Home/Model/FileUpload.class.php';
                $FileUpload = new \FileUpload();
                $path = $FileUpload->save_file($_POST['pname'], "/uploadfiles/do_customer_return/" . date('Y-m-d') . "/");
            }

            $f = M('do_customer_return_status')->add(array("do_customer_return_id" => $_POST['check_id'],
                "content" => $_POST['content'], 'create_time' => time(),
                "admin_user_id" => $_SESSION['admin_user_id'], "status" => $status,
                "url_path" => $path, 'name' => $_POST['attach_name']
            ));
            $this->set_notice(1, "审核操作成功");
        } else {
            $this->set_notice(2, "参数错误");
        }
        $this->redirect("DoCustomerReturn/index");
    }

    public function detail()
    {
        $this->assign('is_print', 1);
        $this->assign("loc_name_2", "详情");
        if (isset($_GET['id'])) {
            $return = M('do_customer_returns')->where("id=%d", array($_GET['id']))->find();
            $return_items = M('do_customer_return_items')
                ->where('do_customer_return_id=%d', array($_GET['id']))->select();
            $this->assign('id', intval($_GET['id']));
            $this->assign('return', $return);
            $this->assign('items', $return_items);
            layout('layouts/detail');
            $this->display();
        } else {
            $this->set_notice(2, "参数有误");
            $this->redirect("DoExplosion/index");
        }

    }

    /**
     * 前台选择产品JS请求返回大类跟货号
     */
    public function get_products_info()
    {
        $id = intval($_REQUEST['id']);
        $item_info = M('products')->alias('a')->field('a.number,b.`name`')
            ->join('LEFT JOIN ' . C('DB_PREFIX') . 'category b on a.category_id = b.id')->find();
        echo json_encode($item_info);
    }

}