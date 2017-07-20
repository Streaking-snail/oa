<?php
namespace Home\Model;
use Home\Model\BaseModel;
class CountInfoModel extends BaseModel{
	
	protected $tableName = 'count_info';
	
	//搜索
	public function search_info( $options=array() ){
		$where = "b.status=1";
		if( !empty($options['key']) ){
			$where .= " and b.name like '%".$this->str_filter($options['key'])."%'";
		}
		$num = isset($options['num'])?intval($options['num']):10;
		$count = $this->alias('a')->join("left join ".C('DB_PREFIX')."products b on b.id=a.product_id")->where($where)->group("b.id")->count();
		$npage = $this->page($count, $num);
		$count_infos = $this->alias('a')->join("left join ".C('DB_PREFIX')."products b on b.id=a.product_id")
					   ->field("b.name as product_name, b.code, b.number, b.pic_path, a.product_id, a.mall_id, a.id")
					   ->where($where)->group('a.product_id')->limit($npage->firstRow . ',' . $npage->listRows)->select();
		return array('count_infos'=>$count_infos,'show_page'=>$npage->show(),'now_page'=>$npage->firstRow);
	}
	
	public function get_count($product_id, $mall_id){
		$count = M('count_info')->where("product_id=%d and mall_id=%d", array($product_id, $mall_id))->count();
		return $count;
	}

	public function search_shop_products( $options=array() ){
		$where = "b.status=1";
		if( intval($options['mall_id'])>0 ){
			$where .= " and a.mall_id=".intval($options['mall_id']);
		}
		if( !empty($options['key']) ){
			$where .= " and b.name like '%".$this->str_filter($options['key'])."%'";
		}
		if( intval($options['product_id'])>0 ){
			$where .= " and a.product_id=".intval($options['product_id']);
		}
		if( intval($options['s_shop_id'])>0 ){
			$where .= " and a.shop_id=".intval($options['s_shop_id']);
		}
		$num = isset($options['num'])?intval($options['num']):10;
		$count = $this->alias('a')->join("left join ".C('DB_PREFIX')."products b on b.id=a.product_id")->where($where)->count();
		$npage = $this->page($count, $num);
		$count_infos = $this->alias('a')->join("left join ".C('DB_PREFIX')."products b on b.id=a.product_id")
					   ->field("b.name as product_name, b.code, b.number, b.pic_path, a.product_id, a.mall_id, a.shop_id, a.id, a.status")
					   ->where($where)->limit($npage->firstRow . ',' . $npage->listRows)->select();
//                echo $this->getlastsql();
//                exit;
		return array('count_infos'=>$count_infos,'show_page'=>$npage->show());
	}
        
        
        public function get_product_info($options=array()){
            $num = isset($options['num'])?intval($options['num']):10;
            $count = $this->alias('a')->join("left join ".C('DB_PREFIX')."products b on b.id=a.product_id")->where($where)->count();
            $npage = $this->page($count, $num);
            
            $count_infos = $this->alias('a')->join("left join ".C('DB_PREFIX')."products b on b.id=a.product_id")
					   ->field("b.name as product_name, b.code, b.number, b.pic_path, a.product_id, a.id, a.mall_id")
					   ->where($where)->limit($npage->firstRow . ',' . $npage->listRows)->select();
            
            $dh_time = M('product_order')->where("id=%d",array($options['product_id']))->select();
            
            $product_info['dh_time']=$dh_time['dh_time'];
            return array('count_infos'=>$count_infos,'shop_product'=>$product_info,'show_page'=>$npage->show());
            
        }
        
        
         public function get_info($product_id,$ptype_status_id) {
             $product_pic = M('product_pic')->where("product_id=%d",array($product_id))->find();
             $product_pic_status = M('product_pic_status')->where("product_pic_id=%d and ptype_status_id=%d",array($product_pic['id'],$ptype_status_id))->find();
             $product_pic_status_attaches = M('product_pic_status_attach')->where('product_pic_status_id=%d',array($product_pic_status['id']))->order("create_time desc")->find();
//             print_r($product_pic_status_attaches);
             return $product_pic_status_attaches;
        }
        
         public function upload(){
            $words = $_POST['content'];
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
        
        
        public function download_csv(){
            include_once SITE_PATH.'/Home/Model/Export.class.php';
            $down = new \export_csv();
            $title = array('物料代码','辅代码','产品名称','店铺名','发货','渠道上新','商城编码','到货时间','交样','文案','拍照','详情页制作','首页制作');
            $mall_id = $_GET['mall_id'];
            $value = $this->table('count_info,products,shop,product_order')->where('products.id = product_order.product_id and count_info.shop_id = shop.id and count_info.product_id = products.id and count_info.mall_id=%d',array($mall_id))->field('products_code , products.number, products.name, shop.name ,product_order.dh_time')->order('count_info.id desc')->select();
            echo $this->getlastsql();
            exit;
        }
        
        public function get_end_time($product_id){
        	$product_pic = M('product_pic')->where("product_id=%d", array($product_id))->find();
        	return $product_pic['finish_time'];
        }
        
        //添加汇总记录
        public function create_info($options=array()){
        	$count_info_data = $options['count_info'];
        	if( empty($count_info_data['product_id']) ){
        		return array("status"=>false, "notice"=>"请选择产品");
        	}
        	if( empty($count_info_data['mall_id']) ){
        		return array("status"=>false, "notice"=>"请选择商城");
        	}
        	if( count($options['shop_ids'])==0 ){
        		return array("status"=>false, "notice"=>"请选择店铺");
        	}
        	$count_info_data['admin_user_id'] = $_SESSION['admin_user_id'];
        	$count_info_data['create_time'] = time();
        	M()->startTrans();
        	foreach($options['shop_ids'] as $value){
        		if( !empty($value) ){
	        		$count_info_data['shop_id'] = intval($value);
	        		$ci = M('count_info')->where("shop_id=%d and product_id=%d", array($value, $count_info_data['product_id']))->find();
	        		if( !$ci ){
		        		$id = M('count_info')->add($count_info_data);
		        		if($id<=0){
		        			M()->rollback();
		        			return array("status"=>false, "notice"=>"添加出错");
		        		}
	        		}
        		}
        	}
        	M()->commit();
        	return array("status"=>true, "notice"=>"ok");
        }
	
        
        public function get_deliver_time($product_order_id){
        	$product_order_deliver = M('product_order_deliver')->where("product_order_id=%d", array($product_order_id))->order("deliver_time desc")->find();
        	return $product_order_deliver['deliver_time'];
        }
        
        public function get_shops($mall_id, $product_id){
        	$shops = D('shop')->where("is_del=0 and status=1 and mall_id=%d", array($mall_id))->select();
        	foreach($shops as $k=>$v){
        		$count_info = M('count_info')->where("shop_id=%d and product_id=%d", array($v['id'], $product_id))->find();
        		if( $count_info && $count_info['status']==1 ){
        			$shops[$k]['is_over'] = true;
        		}else{
        			$shops[$k]['is_over'] = false;
        		}
        	}
        	return $shops;
        }
}