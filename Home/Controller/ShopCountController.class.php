<?php
namespace Home\Controller;
use Common\Common\Controller\AdminBaseController;
class ShopCountController extends AdminBaseController{

	public $locations = array();
	public $mall_id;
	public $product_id;
	public $mall;
	
	function __construct(){
		parent::__construct();
		$this->locations = array(
			 array('is_checked'=>false, 'name'=>'汇总管理', 'url'=>U('ShopCount/index'))
		);
		$this->assign('locations', $this->locations);
		
		$this->product_id = isset($_GET['product_id'])?intval($_GET['product_id']):0;
		
		$this->mall_id = isset($_GET['mall_id'])?intval($_GET['mall_id']):0;
		$this->mall = M('mall')->where("id=%d", array($this->mall_id))->find();
		$this->assign('loc_name_1', $this->mall['name']);
		$search_info['s_shop_id'] = isset($_POST['s_shop_id'])?intval($_POST['s_shop_id']):0;
		$s_shops = M('shop')->where("mall_id=%d and status=1 and is_del=0", array($this->mall_id))->select();
                array_unshift($s_shops, array('name'=>'全部', 'id'=>0));
		$this->assign('s_shops', $s_shops);
		$this->assign('shop_id',$search_info['s_shop_id']);
		$mall_columns = M('mall_colums')->alias('a')->join("left join ".C('DB_PREFIX')."ptype_status b on b.id=a.ptype_status_id")
						->field("if(a.ptype_status_id=10, '到货时间', if(a.ptype_status_id=0,a.name, b.name)) as name, a.ptype_status_id,a.id, a.is_text, a.is_attach, a.mall_id")	
						->where("a.mall_id=%d", array($this->mall_id))->order("a.rank,a.id")->select();
                $this->assign('mall_id',$_GET['mall_id']);
		$this->assign("mall_columns", $mall_columns);
		
		
	}
	
	public function index(){
		$this->assign('loc_name_2', "汇总列表");
		$CountInfo = D('CountInfo');
		$search_info = array();
		$search_info['key'] = isset($_POST['key'])?$_POST['key']:'';
		$search_info['num'] = isset($_POST['num'])?intval($_POST['num']):10;
		$search_info['s_shop_id'] = isset($_POST['s_shop_id'])?intval($_POST['s_shop_id']):0;
		$search_info['product_id'] = $this->product_id;
		$search_info['mall_id'] = $this->mall_id;
		$res = D('CountInfo')->search_shop_products( $search_info );
              //  $shop_product = D('CountInfo')->get_product_info($search_info);
		$this->assign('search_info', $search_info);
                $this->assign('shop_id',$search_info['s_shop_id']);
		$this->assign('count_infos', $res['count_infos']);
		$this->assign('show_page', $res['show_page']);
               // $this->assign('shop_products',$shop_product);
                 $this->assign('number_per_page',$search_info['num']);
                $this->assign('page_number',$res['now_page']);
                $total_count = M('count_info')->alias('a')->join("left join ".C('DB_PREFIX')."products b on b.id=a.product_id")->where("a.mall_id=%d and b.status = 1",array($search_info['mall_id']))->group("product_id")->select();
                $this->assign('total_count',count($total_count));
		$this->show();
	}
        
        public function del(){
            if($_GET['id']!=0){
        		$f = M('count_info')->where("id=%d", array($_GET['id']))->delete();
                if( $f!==false ){
                    $this->set_notice(1, "删除成功");
                }else{
                    $this->set_notice(2, "删除出错，请重试");
            	}
            }else{
                    $this->set_notice(2, "删除出错，请重试");
            }
            	$this->redirect("ShopCount/index",array('mall_id'=>$_GET['mall_id']));
        }
        
         public function upload(){
            $words = $_POST['content'];
            foreach($words as $value){
                $f = M('colums_info')->add(array('mall_colums_id'=>$value['id'],'words'=>$value['value']));
            }
             if($f!==false){
                    $this->set_notice(1, "更新信息成功");
                }
                else{
                    $this->set_notice(2, "更新信息出错");
                }
        }
        
        public function update(){
            $words = $_POST['content'];
            $mall_colums_id= $_POST['mall_colums_id'];
            $f = M('colums_info')->where("$mall_colums_id=%d",array($mall_colums_id))->setField(array('words'=>$words));
            if($f!==false){
                $this->set_notice(1, "添加信息成功");
            }
            else{
                $this->set_notice(2, "添加信息出错");
            }
            $this->redirect("ShopCount/index",array('mall_id'=>$_POST['mall_id'],'product_id'=>$_POST['product_id']));
        }
        
         public function get_info($product_id,$ptype_status_id) {
              $product_pic = M('product_pic')->where("product_id=%d",array($product_id))->find();
             $product_pic_status = M('product_pic_status')->where("product_pic_id=%d and ptype_status_id=%d",array($product_pic['id'],$ptype_status_id))->find();
             $product_pic_status_attaches = M('product_pic_status_attach')->where('product_pic_status_id=%d',array($product_pic_status['id']))->order("create_time desc")->find();
             return $product_pic_status_attach;
        }
        
        
        public function download_csv(){
            include_once SITE_PATH.'/Home/Model/Export.class.php';
//            $titleList = array('物料代码','辅代码','产品名称','店铺名','到货时间','交样','文案','拍照','详情页制作','首页制作','商城编码','发货','渠道上新');
            $titleList = array('物料代码','辅代码','产品名称','店铺名','到货时间');
            $mall_id = $_GET['mall_id'];
            $get_number = M('mall_colums')->where("mall_id=%d",array($mall_id))->select();
            $add = M('mall_colums')->where("ptype_status_id!=10 and mall_id=%d",array($mall_id))->order("id")->limit()->select();
            foreach ($add as $name) {
                if($name['ptype_status_id']==0){
                    array_push($titleList, $name['name']);
                }else{
                    unset($a);
                    $a = M('ptype_status')->where("id=%d",array($name['ptype_status_id']))->find();
                    array_push($titleList, $a['name']);
                }
            }
            $arrs = M('count_info')->alias('a')->join("left join ".C('DB_PREFIX')."products p on p.id=a.product_id ".
                                              "left join ".C('DB_PREFIX')."shop s on s.id=a.shop_id ".
                                              "left join ".C('DB_PREFIX')."product_order po on po.product_id=p.id")
                          ->field("a.shop_id,po.product_id,p.code, p.number, p.name, s.name as shop_name, po.dh_time")
                          ->where("a.mall_id=%d and p.status=1", array($_GET['mall_id']))->select();
            $ptype = M('mall_colums')->where("mall_id=%d",$_GET['mall_id'])->select();
            for($j=0;$j<count($arrs);$j++){
                foreach ($ptype as $v){ 
                    $i=0;
                    unset($get);
                    if($v['ptype_status_id']==0){
                        $get = M('colums_info')->where("mall_colums_id=%d and shop_id=%d and product_id=%d",array($v['id'],$arrs[$j]['shop_id'],$arrs[$j]['product_id']))->order("id desc")->find();
                        array_push($arrs[$j],$get['words']);
                    }else if($v['ptype_status_id']!=10){
                        $product_pic = M('product_pic')->where("product_id=%d",array($arrs[$j]['product_id']))->find();
                        $product_pic_status = M('product_pic_status')->where("product_pic_id=%d and ptype_status_id=%d",array($product_pic['id'],$v['ptype_status_id']))->find();
                        $product_pic_status_attaches = M('product_pic_status_attach')->where('product_pic_status_id=%d',array($product_pic_status['id']))->order("create_time desc")->find();
                        $get = $product_pic_status_attaches; 
                        array_push($arrs[$j], $get['content']);  
                    }
                    $i++;
                    
                }
                unset($arrs[$j]['shop_id']);
                unset($arrs[$j]['product_id']);
            }
           
//            print_r($arrs);
//            exit;
            $export = new \Export();
            $export->export_csv($arrs, $titleList);
        }
        
        public function checked(){
        	if( isset($_GET['id']) ){
        		$f = M('count_info')->where("id=%d", array($_GET['id']))->setField(array("nstatus"=>1, "status"=>1, 
        				"admin_user_id"=>$_SESSION['admin_user_id'], "create_time"=>time()));
        		if( $f!==false ){
        			$this->set_notice(1, "操作成功");
        		}else{
        			$this->set_notice(1, "操作失败");
        		}
        	}else{
        		$this->set_notice(2, "参数错误");
        	}
        	$this->redirect("ShopCount/index", array('mall_id'=>$_GET['mall_id']));
        }
        
        public function add_info(){
        	include_once SITE_PATH.'/Home/Model/FileUpload.class.php';
        	$FileUpload = new \FileUpload();
        	if( isset($_FILES['file']) && !empty($_FILES['file']['name']) ){
        		$path = $FileUpload->save_file($_FILES['file'], "/uploadfiles/shop_counts/".date('Y-m-d')."/");
        	}else{
        		$path = '';
        	}
        	$count_info_status = M('count_info_status')->where("id=%d", array($_POST['id']))->find();
        	$id = M('count_info_status_attach')->add(array(
        			'count_info_status_id'=>$count_info_status['id'],
							        'url'=>$path, 'content'=>isset($_POST['content'])?$_POST['content']:'',
							        'create_time'=>time(), 'admin_user_id'=>$_SESSION['admin_user_id']));
        	$this->redirect("ShopCount/index", array("mall_id"=>$_POST['mall_id']));
        }
        
        public function up_status(){
        	if( isset($_GET['mid']) && isset($_GET['cid']) ){
        		$count_info_status = M('count_info_status')->where("id=%d", array($_GET['mid']))->find();
        		if( $count_info_status['status']==1 ){
        			$this->set_notice(2, "状态已改变");
        		}else{
	        		$f = M('count_info_status')->where("id=%d", array($_GET['mid']))->setField(array('status'=>1, "admin_user_id"=>$_SESSION['admin_user_id'], "checked_time"=>time()));
	        		$count_info = M('count_info')->where("id=%d", array($_GET['cid']))->find();
	        		
	        		$mall_colum = M('mall_colums')->where("id=%d", array($count_info_status['mall_status_id']))->find();
	        		
	        		$next_colum = M('mall_colums')->where("id!=%d and rank>=%d and mall_id=%d and ptype_status_id=0", array($count_info_status['mall_status_id'], $mall_colum['rank'], $count_info['mall_id']))
	        					  ->order("rank asc,id")->find();
	        		if( $next_colum ){
	        			$ci = M('count_info_status')->where("count_info_id=%d and mall_status_id=%d", array($count_info['id'], $next_colum['id']))->find();
	        			if( !$ci ){
			        		$id = M('count_info_status')->add(array(
				        			"admin_user_id"=>$_SESSION['admin_user_id'], 'status'=>0, 'create_time'=>time(),
				        			'mall_status_id'=>$next_colum['id'], "count_info_id"=>$count_info['id']));
			        		if( $id>0 ){
			        			$this->set_notice(1, "操作成功");
			        		}
	        			}
	        		}
        		}
        	}else{
        		$this->set_notice(2, "参数错误");
        	}
        	$this->redirect("ShopCount/index", array("mall_id"=>$_GET['mall_id']));
        }
        
	
}