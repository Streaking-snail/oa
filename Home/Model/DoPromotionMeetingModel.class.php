<?php
namespace Home\Model;
use Home\Model\BaseModel;
class DoPromotionMeetingModel extends BaseModel{
	
	protected $tableName = 'do_promotion_meetings';
	
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
                   $where .=" and a.meeting_time >= $options[time1]";
              }else if( empty($options['time1']) && !empty($options['time2'])){
                   $where .=" and a.meeting_time <= $options[time2]";
              }else{
                   $where .=" and a.meeting_time between $options[time1] and $options[time2]";
              }
        }
		$count = $this->alias("a")->join("left join ".C('DB_PREFIX')."admin_user c on a.admin_user_id=c.id")
                        ->join("left join ".C('DB_PREFIX')."deport d on c.deport_id=d.id")
                        ->where($where)->count();
		$page = $this->page($count, $options['num']);
		$do_promotion_meetings = $this->alias("a")->join("left join ".C('DB_PREFIX')."admin_user c on a.admin_user_id=c.id")
                        ->join("left join ".C('DB_PREFIX')."deport d on c.deport_id=d.id")
                        ->field("a.*")->where($where)->limit($page->firstRow . ',' . $page->listRows)->select();
		return array('do_promotion_meetings'=>$do_promotion_meetings, 'show_page'=>$page->show());
	}
	
	public function create_info($options=array()){
		$options['create_time'] = time();
                $options['admin_user_id'] = $_SESSION['admin_user_id'];
                $options['meeting_time'] = strtotime($options['meeting_time']);
                $options['back_end_time'] = strtotime($options['back_end_time']);
                $options['zc_time'] = strtotime($options['zc_time']);
		$id = $this->add($options);
		if( $id>0 ){
			return array('status'=>true, 'msg'=>"添加成功");
		}else{
			return array('status'=>false, 'msg'=>"添加失败");
		}
	}
	
	public function update_info($options=array()){
		$id = $options['id'];
		unset($options['id']);
                $options['meeting_time'] = strtotime($options['meeting_time']);
                $options['back_end_time'] = strtotime($options['back_end_time']);
                $options['zc_time'] = strtotime($options['zc_time']);
		$f = $this->where("id=%d",array($id))->setField($options);
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