<?php
namespace Home\Model;
use Home\Model\BaseModel;
class DoOutOrderModel extends BaseModel{
	
	protected $tableName = 'do_out_orders';
//	public $secret = 'guangbo';
	//搜索
	public function search_info( $options=array() ){
		$where = "a.is_del=0";
		if( !empty($options['key']) ){
			$where .= " and name like '%".$this->str_filter($options['key'])."%'";
		}
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
                        $where .=" and a.lw_time >= $options[time1]";
                    }else if( empty($options['time1']) && !empty($options['time2'])){
                        $where .=" and a.lw_time <= $options[time2]";
                    }else{
                        $where .=" and a.lw_time between $options[time1] and $options[time2]";
                    }
        }
		$options['num'] = isset($options['num'])?intval($options['num']):10;
		$count = $this->alias("a")->join("left join ".C('DB_PREFIX')."do_out_order_status b on b.do_out_order_id=a.id ")
                        ->join("left join ".C('DB_PREFIX')."admin_user c on a.admin_user_id=c.id")
                        ->join("left join ".C('DB_PREFIX')."deport d on c.deport_id=d.id")
                        ->where($where)->count();
		$page = $this->page($count, $options['num']);
		$do_out_orders = $this->alias("a")->join("left join ".C('DB_PREFIX')."do_out_order_status b on b.do_out_order_id=a.id ")
                        ->join("left join ".C('DB_PREFIX')."admin_user c on a.admin_user_id=c.id")
                        ->join("left join ".C('DB_PREFIX')."deport d on c.deport_id=d.id")
                        ->field("a.*")->where($where)->limit($page->firstRow . ',' . $page->listRows)->select();
		return array('do_out_orders'=>$do_out_orders, 'show_page'=>$page->show());
	}
        //添加
        public function create_info($options=array()){
		$options['create_time'] = time();
                $options['admin_user_id'] = $_SESSION['admin_user_id'];
                $options['lw_time'] = strtotime($options['lw_time']);
		$id = $this->add($options);
		if( $id>0 ){
			return array('status'=>true, 'msg'=>"添加成功");
		}else{
			return array('status'=>false, 'msg'=>"添加失败");
		}
	}
        //修改
        public function update_info($options=array()){
		$id = $options['id'];
		unset($options['id']);
                $options['lw_time'] = strtotime($options['lw_time']);
		$f = $this->where("id=%d",array($id))->setField($options);
		if( $f!==false ){
			return array('status'=>true, 'msg'=>"修改成功");
		}else{
			return array('status'=>false, 'msg'=>"修改失败");
		}
	}
}