<?php
namespace Home\Controller;
use Common\Common\Controller\AdminBaseController;
class CountInfoController extends AdminBaseController{

	public $locations = array();
	
	function __construct(){
		parent::__construct();
		$this->locations = array(
				array('is_checked'=>false, 'name'=>'汇总管理', 'url'=>U('CountInfo/index'))
		);
		$this->assign('locations', $this->locations);
		$this->assign('loc_name_1', "汇总管理");
	}
	
	public function index(){
		$this->assign('loc_name_2', "汇总列表");
		$CountInfo = D('CountInfo');
		$search_info = array();
		$search_info['key'] = isset($_POST['key'])?$_POST['key']:'';
		$search_info['num'] = isset($_POST['num'])?intval($_POST['num']):10;
		$res = $CountInfo->search_info( $search_info );
		$this->assign('search_info', $search_info);
		$this->assign('count_infos', $res['count_infos']);
		$this->assign('show_page', $res['show_page']);
		$malls = M('mall')->where("is_del=0")->order("rank asc")->select();
		$this->assign('malls', $malls);
                $this->assign('number_per_page',$search_info['num']);
                $this->assign('page_number',$res['now_page']);
                $total_count = M('count_info')->alias('a')->join("left join ".C('DB_PREFIX')."products b on b.id=a.product_id")->where("b.status = 1")->group("product_id")->select();
                $this->assign('total_count',count($total_count));
		$this->show();
	}
        
    public function list_items(){
		$this->assign('loc_name_2', "全部项目");
		$CountInfo = D('CountInfo');
		$search_info = array();
		$search_info['key'] = isset($_POST['key'])?$_POST['key']:'';
		$search_info['num'] = isset($_POST['num'])?intval($_POST['num']):10;
		$res = $CountInfo->search_info( $search_info );
		$this->assign('search_info', $search_info);
		$this->assign('count_infos', $res['count_infos']);
		$this->assign('show_page', $res['show_page']);
		$malls = M('mall')->where("is_del=0")->order("rank asc")->select();
		$this->assign('malls', $malls);
		$this->show();
	}
        
    public function get_info($product_id,$ptype_status_id) {
             $product_pic = M('product_pic')->where("product_id=%d",array($product_id))->find();
             echo M()->getlastsql();
             $product_pic_status = M('product_pic_status')->where("product_pic_id=%d and ptype_status_id=%d",array($product_pic['id'],$ptype_status_id))->order('id desc')->find();
             echo M()->getlastsql();
             $product_pic_status_attach = M('product_pic_status_attach')->where('product_pic_status_id=%d',array($product_pic_status['id']))->find();
             echo M()->getlastsql();
//             print_r($product_pic_status_attach);
//             exit;
             return $product_pic_status_attach;
    }

    //搜索商品
    public function get_products(){
    	if( isset($_GET['q']) && !empty($_GET['q']) ){
    		$_GET['q'] = $this->str_filter($_GET['q']);
	    	$products = M('products')->alias("a")->join("left join ".C('DB_PREFIX')."product_pic b on b.product_id=a.id")
	    				->field("a.*")
	    				->where("(a.name like '%".$_GET['q']."%' or a.code like '%".$_GET['q']."%' or a.number like '%".$_GET['q']."%') and b.is_over=1")->select();
	    	if( count($products)>0 ){
	    		$str = "";
	    		foreach($products as $value){
    				$str .= json_encode($value)."\n";
	    		}
	    		echo $str;
	    		exit;
	    	}
    	}
    	json_encode(array('id'=>0,'status_name'=>'暂无记录'))."\n";
    	exit;
    }
    
    public function add_info(){
    	$this->assign('loc_name_2', "添加汇总");
    	$this->assign("malls", D('Mall')->get_mall_options());
    	$this->assign("count_info", array());
       	$this->display();
    }
    public function create_info(){
    	if( isset($_POST['count_info']) ){
    		$res = D('CountInfo')->create_info($_POST);
    		$notice = $res["notice"];
    		if( $res['status'] ){
    			$this->set_notice(1, $notice);
    			$this->redirect("CountInfo/index");
    			exit;
    		}
    	}else{
    		$notice ="参数错误";
    	}
    	$this->set_notice(2, $notice);
    	$this->redirect($url);
    }
    public function select_shops(){
    	layout(false);
    	$shops = M('shop')->where("mall_id=%d and is_del=0", array($_POST['mall_id']))->select();
    	$this->assign("shops", $shops);
    	$this->display("CountInfo/_shop_list");
    }
        
    public function upload(){
            $words = $_POST['content'];
            if($_POST['shop_id']!=0){
                foreach($words as $value){
                    $f = M('colums_info')->add(array('mall_colums_id'=>$value['id'],'words'=>$value['value'],'shop_id'=>$_POST['shop_id'],'product_id'=>$_POST['product_id']));
                }
                if($f!==false){
                    $this->set_notice(1, "更新信息成功");
                }
                else{
                    $this->set_notice(2, "更新信息出错");
                }
            }else{
                foreach($words as $value){
                    $f = M('colums_info')->add(array('mall_colums_id'=>$value['id'],'words'=>$value['value'],'shop_id'=>$_POST['shop_id'],'product_id'=>$_POST['product_id']));
                }
                if($f!==false){
                    $this->set_notice(1, "更新信息成功");
                }
                else{
                    $this->set_notice(2, "更新信息出错");
                }
            }
            $this->redirect("ShopCount/index",array('mall_id'=>$_POST['mall_id']));
            
        }
        
        
        public function download_csv() {
            include_once SITE_PATH.'/Home/Model/Export.class.php';
            $titleList = array('物料代码','辅代码','产品名称');
            $mall = M('mall')->select();
            foreach($mall as $v){
                array_push($titleList, $v['name']);
            }
//            $arrs = M('product_order')->alias('a')->join("left join ".C('DB_PREFIX')."products p on p.id=a.product_id ".
//                                              "left join ".C('DB_PREFIX')."product_pic c on p.id=c.product_id ".
//                                              "left join ".C('DB_PREFIX')."count_info d on p.id=d.product_id ")
//                                      ->field("a.product_id,p.code,p.number,p.name")
//                                      ->where("c.is_over=1 and c.is_del=0 and p.status=1")->group('a.product_id')->select();
            
            $arrs = M('products')->alias('a')->join( "left join ".C('DB_PREFIX')."count_info b on a.id=b.product_id ")
                                      ->field("b.product_id,a.code,a.number,a.name")
                                      ->where("a.status=1")->group('b.product_id')->select();
            
//            $arrs = M('count_info')->alias('a')->join("left join ".C('DB_PREFIX')."products b on b.id=a.product_id")
//					   ->field(" a.product_id, b.code,b.number,b.name as product_name,")
//					   ->where("b.status=1")->group('a.product_id')->select();
            for($i=0;$i<count($arrs);$i++){
                foreach ($mall as $value) {
                    unset($get);
                    $get = M('count_info')->where("mall_id=%d and product_id=%d",array($value['id'],$arrs[$i]['product_id']))->select();
                    array_push($arrs[$i], count($get));
                }
                unset($arrs[$i]['product_id']);
            }
            
            $export = new \Export();
            $export->export_csv($arrs, $titleList);
        }
	
}