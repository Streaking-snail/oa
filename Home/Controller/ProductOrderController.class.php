<?php
namespace Home\Controller;
use Common\Common\Controller\AdminBaseController;
class ProductOrderController extends AdminBaseController {
    
	public $locations = array();
	public $ProductOrder;
	
	function __construct(){
		parent::__construct();
		$this->locations = array(
				array('is_checked'=>false, 'name'=>'产品管理', 'url'=>U('ProductOrder/index'))
		);
		$this->ProductOrder = D('ProductOrder');
		$this->assign('loc_name_1', "产品管理");
		$this->assign('locations', $this->locations);
	}
	
	public function history(){
		$this->assign("loc_name_2", "历史删除项目");
		$search_info['is_del'] = 1;
		$search_info['num'] = isset($_POST['num'])?intval($_POST['num']):isset($_GET['num'])?intval($_GET['num']):10;
		$search_info['number'] = $_POST['number']; 
		$search_info['code'] = $_POST['code'];
		$this->assign('search_info', $search_info);
		$res = $this->ProductOrder->search_info($search_info);
		$this->assign('ProductOrder', $this->ProductOrder);
		$this->assign('product_orders', $res['product_orders']);
		$this->assign('show_page', $res['show_page']);
                $total_count = M('product_order')->where("is_del=1")->select();
                $this->assign('total_count',count($total_count));
		$this->display("ProductOrder/index");
	}
	
	public function list_items(){
		$this->assign("loc_name_2", "全部项目");
		$search_info['ptype_id'] = $this->ptype_id;
		$search_info['status'] = isset($_POST['status'])?intval($_POST['status']):isset($_GET['status'])?intval($_GET['status']):0;
		$search_info['num'] = isset($_POST['num'])?intval($_POST['num']):intval($_GET['num']);
                $search_info['code'] = isset($_POST['code'])?$_POST['code']:'';
                $search_info['number'] = isset($_POST['number'])?$_POST['number']:'';
                $search_info['name'] = isset($_POST['name'])?$_POST['name']:'';
                $search_info['time'] = isset($_POST['time'])?$_POST['time']:'';
                $search_info['time1'] = isset($_POST['time1'])?intval(strtotime($_POST['time1'])):'';
                $search_info['time2'] = isset($_POST['time2'])?intval(strtotime($_POST['time2'])):'';
                $search_info['sort'] = isset($_POST['sort'])?$_POST['sort']:'';
                $search_info['show'] = isset($_POST['show'])?intval($_POST['show']):'0';
                $this->assign('search_info', $search_info);
                $sort_arrs = array (
                    array('','默认'),
                    array('deliver_time_up', '计划大货前样升序'),
                    array('deliver_time_down', '计划大货前样降序'),
                    array('dh_time_up','到货时间升序'),
                    array('dh_time_down','到货时间降序'),
                );
		$res = $this->ProductOrder->search_info($search_info);
		$this->assign('ProductOrder', $this->ProductOrder);
		$this->assign('product_orders', $res['product_orders']);
		$this->assign('show_page', $res['show_page']);
                $total_count = M('product_order')->alias('a')->join("left join ".C('DB_PREFIX')."products b on b.id=a.product_id")
                                                 ->where("a.is_del=0 and b.status=1")->select();
                $this->assign('total_count',count($total_count));
                $this->assign('sort_arrs',$sort_arrs);
                $this->assign('is_more_search',1);
                $this->assign('is_schedule', 1);
		$this->display("ProductOrder/index");
	}
	
	public function index(){
		$this->assign("loc_name_2", "未完成列表");
		$search_info['is_finish'] = 2;
		$search_info['ptype_id'] = $this->ptype_id;
		$search_info['status'] = isset($_POST['status'])?intval($_POST['status']):isset($_GET['status'])?intval($_GET['status']):0;
		$search_info['num'] = isset($_POST['num'])?intval($_POST['num']):intval($_GET['num']);
		if( empty($search_info['status']) ){
			$search_info['is_over'] = 0;
		}
                $search_info['code'] = isset($_POST['code'])?$_POST['code']:'';
                $search_info['number'] = isset($_POST['number'])?$_POST['number']:'';
                $search_info['name'] = isset($_POST['name'])?$_POST['name']:'';
                $search_info['time'] = isset($_POST['time'])?$_POST['time']:'';
                $search_info['time1'] = isset($_POST['time1'])?intval(strtotime($_POST['time1'])):'';
                $search_info['time2'] = isset($_POST['time2'])?intval(strtotime($_POST['time2'])):'';
                $search_info['sort'] = isset($_POST['sort'])?$_POST['sort']:'';
                $search_info['show'] = isset($_POST['show'])?intval($_POST['show']):'0';
                $this->assign('search_info', $search_info);
                $sort_arrs = array (
                    array('','默认'),
                    array('deliver_time_up', '计划大货前样升序'),
                    array('deliver_time_down', '计划大货前样降序'),
                    array('dh_time_up','到货时间升序'),
                    array('dh_time_down','到货时间降序'),
                );
		$res = $this->ProductOrder->search_info($search_info);
		$this->assign('ProductOrder', $this->ProductOrder);
		$this->assign('product_orders', $res['product_orders']);
		$this->assign('show_page', $res['show_page']);
                 $this->assign('number_per_page',$search_info['num']);
                $this->assign('page_number',$res['now_page']);
                $total_count = M('product_order')->alias('a')->join("left join ".C('DB_PREFIX')."products b on b.id=a.product_id")
                                                ->where("a.is_del=0 and a.dh_time='' and b.status=1")->select();
                $this->assign('total_count',count($total_count));
                $this->assign('sort_arrs',$sort_arrs);
                $this->assign('is_more_search',1);
                $this->assign('is_schedule', 1);
    	        $this->display();
    }
    
    public function edit(){
    	$this->assign("loc_name_2", "修改");
    	$product_order = M('product_order')->alias('a')->join("left join ".C("DB_PREFIX")."products b on b.id=a.product_id")
    					 ->field("a.*,b.code,b.name,b.number")->where("a.id=%d", array($_GET['id']))->find();
        
    	$this->assign('product_order', $product_order);
    	$this->display();
    }
    
    public function update_info(){
    	if( isset($_POST['product_order']) ){
    		$_POST['product_order']['admin_user_id'] = $this->admin_user_id;
    		$res = D('ProductOrder')->update_info($_POST['product_order']);
    		$notice = $res['notice'];
    		if( $res['status'] ){
    			$this->set_notice(1, $notice);
    			$this->redirect("ProductOrder/list_items");
    		}
    	}else{
    		$notice = "参数错误";
    	}
    	$this->set_notice(2, $notice);
    	$this->redirect('ProductOrder/edit', array('id'=>$_POST['product_order']['id']));
    }
    
    public function del(){
    	$f = M('product_order')->where("id=%d", array($_GET['id']))->setField(array('is_del'=>1));
    	if( $f!==false ){
    		$this->set_notice(1, "删除成功");
    	}else{
    		$this->set_notice(2, "删除出错，请重试");
    	}
    	$this->redirect("ProductOrder/index");
    }
    
    public function add_deliver_num(){
    	$this->assign("loc_name_2", "添加到货数");
    	$product_order = M('product_order')->where("id=%d", array($_GET['id']))->find();
    	$this->assign('product_order', $product_order);
    	$deliver_num = M('product_order_deliver')->where("product_order_id=%d", array($product_order['id']))->sum("num");
    	$this->assign('deliver_num', $deliver_num);
    	$this->display();
    }
    
    public function create_deliver(){
    	if( isset($_POST['product_order_deliver']) ){
    		$res = D('ProductOrder')->add_deliver_num($_POST['product_order_deliver']);
    		$notice = $res["notice"];
    		if( $res['status'] ){
    			$this->set_notice('1', $notice);
    			$this->redirect("ProductOrder/list_items");
    		}
    	}else{
    		$notice = "参数错误";
    	}
    	$this->set_notice(2, $notice);
    	$this->redirect("ProductOrder/add_deliver_num", array('id'=>$_POST['product_order_deliver']['product_order_id']));
    }
    
}