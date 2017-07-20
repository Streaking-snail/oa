<?php
namespace Home\Model;
use Home\Model\BaseModel;
class DoPostCodeModel extends BaseModel{
	
	protected $tableName = 'do_post_codes';
	
	//搜索
	public function search_info( $options=array() ){
		$where = "a.is_del=0";
		if( !empty($options['key']) ){
			$where .= " and name like '%".$this->str_filter($options['key'])."%'";
		}
		$options['num'] = isset($options['num'])?intval($options['num']):10;
		$user = $this->get_admin_user();
		if( $user['is_admin']==0 && $user['id']!=1 ){
			$where .= " and a.admin_user_id=".$user['id'];
		}else{
                if( !empty($options['admin_user']) ){
//                        $admin_user = M('Admin_user')->where("name='$options[admin_user]'")->find();
//                        if( !$admin_user['id'] ){
//                            $admin_user['id'] = $options['deport'];
//                        }
                        $where .= " and c.name = '$options[admin_user]'";
                }
                if( !empty($options['deport']) ){
//                        $deport = M('Deport')->where("name='$options[deport]'")->find();
//                        if( !$deport['id'] ){
//                           $deport['id'] = $options['deport'];
//                        }
                        $where .= " and d.name = '$options[deport]'";
                }
		}
        if( !empty($options['time1']) || !empty($options['time2']) ){
                    if( !empty($options['time1']) && empty($options['time2']) ){
                        $where .=" and apply_time >= $options[time1]";
                    }else if( empty($options['time1']) && !empty($options['time2'])){
                        $where .=" and apply_time <= $options[time2]";
                    }else{
                        $where .=" and apply_time between $options[time1] and $options[time2]";
                    }
        }
		$count = $this->alias("a")->join("left join ".C("DB_PREFIX")."admin_user c on a.admin_user_id=c.id")
                        ->join("left join ".C("DB_PREFIX")."deport d on c.deport_id=d.id")
                        ->where($where)->count();
		$page = $this->page($count, $options['num']);
		$do_post_codes = $this->alias("a")->join("left join ".C("DB_PREFIX")."admin_user c on a.admin_user_id=c.id")
                        ->join("left join ".C("DB_PREFIX")."deport d on c.deport_id=d.id")
                        ->field("a.*")->where($where)->limit($page->firstRow . ',' . $page->listRows)->select();
		return array('do_post_codes'=>$do_post_codes, 'show_page'=>$page->show());
	}
	//添加
	public function create_info($options=array(),$items=array()){
		$options['create_time'] = time();
                $options['admin_user_id'] = $_SESSION['admin_user_id'];
                $options['apply_time'] = strtotime($options['apply_time']);
		$id = $this->add($options);
                foreach( $items as $key => $val){
                    if( $val['product_id'] && $val['change_id'] && $val['barcode'] && $val['plan_order_price'] && $val['plan_change_price'] && $val['unit'] && $val['num']){
                        $val['do_post_code_id']=$id;
                        $val['create_time'] = time();
                        $val['admin_user_id'] = $_SESSION['admin_user_id'];
                        $ids = M('do_post_code_products')->add($val);
                    }
                }
		if( $id>0){
			return array('status'=>true, 'msg'=>"添加成功");
		}else{
			return array('status'=>false, 'msg'=>"添加失败");
		}
	}
	//修改
	public function update_info($options=array(),$items=array()){
		$id = $options['id'];
		unset($options['id']);
                $options['apply_time'] = strtotime($options['apply_time']);
		$f = $this->where("id=%d",array($id))->setField($options);
                $f1 =  M('do_post_code_products')->where('do_post_code_id=%d', $id)->delete();
                if( $f1 ){
                    foreach( $items as $key => $val){
                        if( $val['product_id'] && $val['change_id'] && $val['barcode'] && $val['plan_order_price'] && $val['plan_change_price'] && $val['unit'] && $val['num']){
                            $val['do_post_code_id']=$id;
                            $val['create_time'] = time();
                            $val['admin_user_id'] = $_SESSION['admin_user_id'];
                            $ids = M('do_post_code_products')->add($val);
                        }
                    }
                }
//                foreach( $items as $key => $val){
//                    if( $val['product_id'] && $val['change_id'] && $val['barcode'] && $val['plan_order_price'] && $val['plan_change_price'] && $val['unit'] && $val['num']){
//                        $val['order_time'] = strtotime($val['order_time']);
//                        $f1 = M('do_post_code_products')->where("id=%d",array($val['id']))->setField($val);
//                    }
//                }
		if( $f!==false ){
			return array('status'=>true, 'msg'=>"修改成功");
		}else{
			return array('status'=>false, 'msg'=>"修改失败");
		}
	}
	
	//显示状态名称
	public function get_status($id){
		$status = M('do_business_status')->where("do_business_id=%d", array($id))->order("id desc")->find();
		if( $status ){
			return $status['status']==1?"<span style=''>审核中</span>":"<span>审核不通过</span>";
		}else{
			return "未审核";
		}
	}
	
	//获取状态内容
	public function get_status_content(){
		$status = M('do_business_status')->where("do_business_id=%d", array($id))->order("id desc")->find();
		if( $status ){
			return $status['status']==1?"<span style=''>审核中</span>":"<span>审核不通过</span>";
		}else{
			return "未审核";
		}
	}
	
	public function get_last_checked_name($id){
		$status = M('do_business_status')->where("do_business_id=%d", array($id))->order("id desc")->find();
		if( $status ){
			return $status['status']==1?"<span style=''>审核中</span>":"<span>审核不通过</span>";
		}else{
			return "未审核";
		}
	}
	
}