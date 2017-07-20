<?php
namespace Home\Model;
use Home\Model\BaseModel;
class ProductPicModel extends BaseModel{
	
	protected $tableName = 'product_pic';
	//搜索
	public function search_info( $options=array() ){
		if( $options['is_del']==1 ){
			$where = " a.is_del=1";
		}else{
			$where = " a.is_del=0";
		}
                if($options['is_finish']==2)
                {
                    $where .= " and a.is_over=0";
                }
                
		if( !empty($options['key']) ){
			$where .= " and b.name like '%".$this->str_filter($options['key'])."%'";
		}
//		if( !empty($options['number']) ){
//			$where .= " and (b.number like '%".$this->str_filter($options['number'])."%' or b.code like '%".$this->str_filter($options['number'])."%')";
//		}
		if( intval($options['status'])!=0 ){
			$where .= " and c.ptype_status_id=".intval($options['status']);
		}
                if( !empty($options['code']) ){
                        $where .=" and b.code like '%".$this->str_filter($options['code'])."%'";  
                }
                if( !empty($options['number']) ){
                        $where .=" and b.number like '%".$this->str_filter($options['number'])."%'";  
                }
                if( !empty($options['name']) ){
                        $where .=" and b.name like '%".$this->str_filter($options['name'])."%'";  
                }
                if( !empty($options['pic']) ){
                        $where .=" and c.ptype_status_id=$options[pic] and c.status = 0";
                }
		$num = isset($options['num'])?intval($options['num']):10;
		$count = $this->alias('a')->join("left join ".C('DB_PREFIX')."products b on b.id=a.product_id".
				" left join ".C('DB_PREFIX')."product_pic_status c on c.product_pic_id=a.id")
		        ->where($where)->field("count(distinct a.id) as total_count")->find();
		$npage = $this->page($count['total_count'], $num); 
//                $product_pics = $this->distinct(true)->alias('a')->join("left join ".C('DB_PREFIX')."products b on b.id=a.product_id".
//						" left join ".C('DB_PREFIX')."product_pic_status c on c.product_pic_id=a.id")
//						  ->field("a.*, b.number, b.code, b.name")
//						  ->where($where)->order("a.create_time desc")->limit($npage->firstRow . ',' . $npage->listRows)->select();
		$product_pics = $this->alias('a')->join("left join ".C('DB_PREFIX')."products b on b.id=a.product_id".
						" left join ".C('DB_PREFIX')."product_pic_status c on c.product_pic_id=a.id")
						  ->field("a.*, b.number, b.code, b.name")
						  ->where($where)->group('a.id')->order("a.create_time desc")->limit($npage->firstRow . ',' . $npage->listRows)->select();
                return array('product_pics'=>$product_pics,'show_page'=>$npage->show(),'now_page'=>$npage->firstRow);
           
	}

	public function get_show_time($time){
		$t = time()-$time;
		$d = intval($t/3600/24);
		$h = intval($t/3600%24);
		$m = intval($t%3600/60);
		$s = intval($t%3600%60);
		$str = "";
		if( $d>0 ){
			$str .= $d."天";
		}
		if( $h>0 ){
			$str .= $h."小时";
		}
		if( $m>0 ){
			$str .= $m."分";
		}
		if( $s>0 ){
			$str .= $s."秒";
		}
		return $str;
	}
	
	public function get_day($time){
		$t = time()-$time;
		$d = intval($t/3600/24);
		return $d;
	}
	
	public function get_pic_status($product_pic_id, $status_id){
		$product_pic_status = M('product_pic_status')->where("product_pic_id=%d and ptype_status_id=%d", array($product_pic_id, $status_id))->find();
		if( $product_pic_status ){
                   return $product_pic_status;
                }else{
                   $product_pic = M('product_pic')->where("id=%d", array($product_pic_id))->find();
                   return array('create_time'=>$product_pic['create_time'], 'ptype_status_id'=>0);
                }
	}
	
	public function get_pic_status_attach($product_pic_id, $status_id){
		$product_pic_status = M('product_pic_status')->where("product_pic_id=%d and ptype_status_id=%d", array($product_pic_id, $status_id))->find();
		if( $product_pic_status ){
                    $product_pic_status_attaches = M('product_pic_status_attach')->alias('a')->field("a.*,b.name")
                                                   ->join("left join ".C('DB_PREFIX')."admin_user b on b.id=a.admin_user_id")
                                                   ->where("product_pic_status_id=%d", array($product_pic_status['id']))->order("a.create_time desc, a.id desc")->select();
                    return $product_pic_status_attaches;
                }else{
                    return array();
                }
	}
	
	public function get_status_info($product_pic_id){
		$ptype_id = 3;
		$ptype_status = M('ptype_status')->where("ptype_id=%d", array($ptype_id))->order("rank desc,id desc")->find();
		$product_pic = M('product_pic')->where("id=%d", array($product_pic_id))->find();
		if( $product_pic ){
			$product_pic_status = M('product_pic_status')->alias("a")->join("left join ".C('DB_PREFIX')."ptype_status ps on ps.id=a.ptype_status_id")
								  ->field("a.*, ps.name")
								  ->where("a.product_pic_id=%d", array($product_pic['id']))->order("a.id desc")->find();
			if( $product_pic_status ){
				return $product_pic_status;
			}
		}
		return array('create_time'=>$product_pic['create_time'], "is_over"=>0);
	}
        
        public function getRefuse($ptype_status_id, $product_pic_id){
                $product_pic_status = M('product_pic_status')->where("product_pic_id=%d and ptype_status_id=%d", array($product_pic_id, $ptype_status_id))->find();
                $arrs = M('product_pic_status_log')->alias('a')->join(
                            "left join ".C('DB_PREFIX')."product_pic_status b on a.product_pic_status_id=b.id ".
                            "left join ".C('DB_PREFIX')."admin_user au on au.id=a.admin_user_id")
                ->field("a.*,b.product_pic_id, au.name")
                ->where("a.product_pic_status_id=%d", array($product_pic_status['id']))->order("a.create_time desc")->select();
                return $arrs;
        }
        
        public function get_status($id){
            $status = M('product_pic_status_attach')->alias('a')->join(
                    "left join ".C('DB_PREFIX')."product_pic_status b on a.product_pic_status_id=b.id")
                    ->field("b.status")
                    ->where("a.id=%d",$id)->find();
            return $status;
        }
	
}