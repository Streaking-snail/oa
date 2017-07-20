<?php
namespace Home\Model;
use Home\Model\BaseModel;
class DoTurnGoodModel extends BaseModel{
	
	protected $tableName = 'do_turn_goods';
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
                    $where .=" and c.name='$options[admin_user]'";
                }
                if( !empty($options['deport']) ){
                    $where .=" and d.name='$options[deport]'";
                }
		}
        if( !empty($options['time1']) || !empty($options['time2']) ){
              if( !empty($options['time1']) && empty($options['time2']) ){
                   $where .=" and a.tg_time >= $options[time1]";
              }else if( empty($options['time1']) && !empty($options['time2'])){
                   $where .=" and a.tg_time <= $options[time2]";
              }else{
                   $where .=" and a.tg_time between $options[time1] and $options[time2]";
              }
        }
		$options['num'] = isset($options['num'])?intval($options['num']):10;
		$count = $this->alias("a")->join("left join ".C('DB_PREFIX')."admin_user c on a.admin_user_id=c.id")
                        ->join("left join ".C('DB_PREFIX')."deport d on a.office_id=d.id")
                        ->where($where)->count();
		$page = $this->page($count, $options['num']);
                $do_turn_goods = M('do_turn_goods')->alias('a')
                                ->join("left join ".C('DB_PREFIX')."admin_user c on a.admin_user_id=c.id")
                                ->join("left join ".C('DB_PREFIX')."deport d on a.office_id=d.id")
                                ->field("a.*")->where($where)->limit($page->firstRow . ',' . $page->listRows)->select();

		return array('do_turn_goods'=>$do_turn_goods, 'show_page'=>$page->show());
	}
        //添加
        public function create_info($options=array(),$items=array()){
		$options['create_time'] = time();
                $options['admin_user_id'] = $_SESSION['admin_user_id'];
                $options['tg_time'] = strtotime($options['tg_time']);
		$id = $this->add($options);
                foreach( $items as $key => $val){
                    if( $val['number'] && $val['name'] && $val['num'] && $val['office_id'] && $val['content']){
                        $val['do_turn_good_id']=$id;
                        $val['create_time'] = time();
                        $val['admin_user_id'] = $_SESSION['admin_user_id'];
                        $ids = M('do_turn_good_items')->add($val);
                    }
                }
		if( $id>0 ){
			return array('status'=>true, 'msg'=>"添加成功");
		}else{
			return array('status'=>false, 'msg'=>"添加失败");
		}
	}
        //修改
        public function update_info($options=array(),$items=array()){
		$id = $options['id'];
		unset($options['id']);
                $options['tg_time'] = strtotime($options['tg_time']);
		$f = $this->where("id=%d",array($id))->setField($options);
                $f1 = M('do_turn_good_items')->where("do_turn_good_id=%d", $id)->delete();
                if($f1){
                    foreach( $items as $key => $val){
                        if( $val['number'] && $val['name'] && $val['num'] && $val['office_id'] && $val['content']){
                            $val['do_turn_good_id']=$id;
                            $val['create_time'] = time();
                            $val['admin_user_id'] = $_SESSION['admin_user_id'];
                            $ids = M('do_turn_good_items')->add($val);
                        }
                    }
                }
//                foreach( $items as $key => $val){
//                    if( $val['number'] && $val['name'] && $val['num'] && $val['office_id'] ){
//                        $f1 = M('do_turn_good_items')->where("id=%d",array($val['id']))->setField($val);
//                    }
//                }
		if( $f!==false && $f1!==false){
			return array('status'=>true, 'msg'=>"修改成功");
		}else{
			return array('status'=>false, 'msg'=>"修改失败");
		}
	}
        
        //获取状态内容
	public function get_status($do_turn_good_id){
		$process_type = M('process_types')->where("controller_name='DoTurnGood'")->find();
		$process_type_status = M('process_type_status')->alias("a")
							   ->join("left join ".C('DB_PREFIX')."do_turn_good_status b on b.process_type_status_id=a.id")
							   ->join("left join ".C('DB_PREFIX')."admin_user au on au.id=a.checked_user_id")
							   ->field("a.id, a.rank, a.name, ifnull(au.name, au.username) as username, b.status, a.checked_user_id")
							   ->where("b.do_turn_good_id=%d", array($do_turn_good_id))->order("b.id desc")->find();
		if( $process_type_status ){
			if( $process_type_status['status']==2 ){
				$process_type_status = M('process_type_status')->alias("a")
									   ->join("left join ".C('DB_PREFIX')."admin_user au on au.id=a.checked_user_id")
									   ->field("a.id, a.rank, a.name, ifnull(au.name, au.username) as username, a.checked_user_id")
									   ->where("a.process_type_id=%d and (a.rank<=%d and a.id!=%d)", array($process_type['id'], $process_type_status['rank'], $process_type_status['id']))
									   ->order("a.rank desc,a.id desc")->find();
				return $process_type_status;
			}else{
				$process_type_status = M('process_type_status')->alias("a")
									   ->join("left join ".C('DB_PREFIX')."admin_user au on au.id=a.checked_user_id")
									   ->field("a.id, a.rank, a.name, ifnull(au.name, au.username) as username, a.checked_user_id")
									   ->where("a.process_type_id=%d and (a.rank>=%d and a.id!=%d)", array($process_type['id'], $process_type_status['rank'], $process_type_status['id']))
									   ->order("a.rank,a.id")->find();
				return $process_type_status;
			}
		}else{
			$process_type_status= M('process_type_status')->alias("a")
								  ->join("left join ".C('DB_PREFIX')."admin_user au on au.id=a.checked_user_id")
								  ->field("a.id, a.rank, a.name, ifnull(au.name, au.username) as username, a.checked_user_id")
								  ->where("a.process_type_id=%d", array($process_type['id']))
								  ->order("a.rank,a.id")->find();
			return $process_type_status;
		}
	}
        //获取状态内容
	public function get_status_content(){
		$status = M('do_turn_good_status')->where("do_turn_good_id=%d", array($id))->order("id desc")->find();
		if( $status ){
			return $status['status']==1?"<span style=''>审核中</span>":"<span>审核不通过</span>";
		}else{
			return "未审核";
		}
	}
	
	public function get_last_checked_name($id){
		$status = M('do_turn_good_status')->where("do_turn_good_id=%d", array($id))->order("id desc")->find();
		if( $status ){
			return $status['status']==1?"<span style=''>审核中</span>":"<span>审核不通过</span>";
		}else{
			return "未审核";
		}
	}
        
        //获取当前状态
	public function get_local_status( $do_turn_good_id ){
		$process_type_status = M('process_type_status')->alias("a")
							   ->join("left join ".C('DB_PREFIX')."do_turn_good_status b on b.process_type_status_id=a.id")
							   ->join("left join ".C('DB_PREFIX')."admin_user au on au.id=a.checked_user_id")
							   ->field("a.id, a.rank, a.name, ifnull(au.name, au.username) as username, b.status, a.checked_user_id")
							   ->where("b.do_turn_good_id=%d", array($do_turn_good_id))->order("b.id desc")->find();
		return $process_type_status;
	}
        
        //判断否为审核权限
	public function is_checked_power($user_id, $do_turn_good_id){
		$s = $this->get_status($do_turn_good_id);
		if( $s['checked_user_id']==$user_id ){
			return true;
		}else{
			return false;
		}
	}
}