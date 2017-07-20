<?php
namespace Home\Model;
use Home\Model\BaseModel;
class DoLeaveModel extends BaseModel{
	
	protected $tableName = 'do_leaves';
	
	//搜索
	public function search_info( $options=array() ){
		$where = " a.is_del=0 ";
		if( !empty($options['key']) ){
			$where .= " and a.name like '%".$this->str_filter($options['key'])."%'";
		}
		$user = $this->get_admin_user();
		if( $user['is_admin']==0 && $user['id']!=1 ){
			$where .= " and a.admin_user_id=".$user['id'];
		}else{
			if( !empty($options['deport']) ){
				$seach =M('deport');
				$deport_name=$seach->field("id")->where("name like '%".$this->str_filter($options['deport'])."%'")->find();
				if($deport_name['id']){
					$where .= " and a.admin_user_id = ".$deport_name['id']."";
				}else {
					$where .= " and a.admin_user_id < 0";
				}
			}
			if( !empty($options['admin_user']) ){
				$seach =M('admin_user');
				$username=$seach->field("id")->where("name like '%".$this->str_filter($options['admin_user'])."%'")->find();
				if($username['id']){
					$where .= " and a.admin_user_id = ".$username['id']."";
				}else {
					$where .= " and a.admin_user_id < 0";
				}
			}
		}
		if( !empty($options['time1']) ){
			$where .= " and a.create_time>=".strtotime($options['time1']);
		}
		if( !empty($options['time2']) ){
			$where .= " and a.create_time<=".strtotime($options['time2']);
		}
		if( !empty($options['time3']) ){
			$where .= " and a.start_time>=".strtotime($options['time3']);
		}
		if( !empty($options['time4']) ){
			$where .= " and a.end_time<=".strtotime($options['time4']);
		}
		$options['num'] = isset($options['num'])?intval($options['num']):10;
		$count = $this->alias("a")->where($where)->count();
		$page = $this->page($count, $options['num']);
		$seach =M('do_leaves');
		$doleave = $seach->alias("a")->join("left join ".C("DB_PREFIX")."admin_user b on b.id=a.admin_user_id")
		->join("left join ".C("DB_PREFIX")."deport c on c.id=a.deport_id")
		->field("a.*,ifnull(b.name, b.username) as username,c.name as deport_name")
		->where($where)->limit($page->firstRow . ',' . $page->listRows)->select();
		return array('do_leaves'=>$doleave, 'show_page'=>$page->show());
	}
	
	public function create_info($options=array()){
		$res = $this->valid($options);
		if(!$res['status']) return $res;
		$options['rank'] = isset($options['rank'])?intval($options['rank']):0;
		$options['start_time'] = strtotime($options['start_time']);
		$options['end_time'] = strtotime($options['end_time']);
		$options['create_time'] = time();
		$id = $this->add($options);
		if( $id>0 ){
			return array('status'=>true, 'msg'=>"添加成功");
		}else{
			return array('status'=>false, 'msg'=>"添加失败");
		}
	}
	
	public function update_info($options=array()){
		$res = $this->valid($options);
		if(!$res['status']) return $res;
		$options['start_time'] = strtotime($options['start_time']);
		$options['end_time'] = strtotime($options['end_time']);
		$options['create_time'] = strtotime($options['create_time']);
		$options['rank'] = isset($options['rank'])?intval($options['rank']):0;
		$id = $options['id'];
		unset($options['id']);
		$f = M('do_leaves')->where("id=%d",array($id))->setField($options);
		if( $f!==false ){
			return array('status'=>true, 'msg'=>"修改成功");
		}else{
			return array('status'=>false, 'msg'=>"修改失败");
		}
	}
	
	public function valid( $options=array() ){
		if( empty($options['no']) ){
			return array('status'=>false, 'msg'=>"请输入单据号");
		}
		return array('status'=>true, 'msg'=>'ok');
	}
	
	//获取状态内容
	public function get_status_content(){
		$status = M('do_leaves_status')->where("leaves_id=%d", array($id))->order("id desc")->find();
		if( $status ){
			return $status['status']==1?"<span style=''>审核中</span>":"<span>审核不通过</span>";
		}else{
			return "未审核";
		}
	}
	
	public function get_last_checked_name($id){
		$status = M('do_leaves_status')->where("leaves_id=%d", array($id))->order("id desc")->find();
		if( $status ){
			return $status['status']==1?"<span style=''>审核中</span>":"<span>审核不通过</span>";
		}else{
			return "未审核";
		}
	}
        
        	//获取当前状态
	public function get_local_status( $doleave_id ){
		$process_type_status = M('process_type_status')->alias("a")
							   ->join("left join ".C('DB_PREFIX')."do_leaves_status b on b.process_type_status_id=a.id")
							   ->join("left join ".C('DB_PREFIX')."admin_user au on au.id=a.checked_user_id")
							   ->field("a.id, a.rank, a.name, ifnull(au.name, au.username) as username, b.status, a.checked_user_id")
							   ->where("b.leaves_id=%d", array($doleave_id))->order("b.id desc")->find();
		return $process_type_status;
	}
	
	//获取状态内容
	public function get_status($doleave_id){
		$process_type = M('process_types')->where("controller_name='DoLeave'")->find();
		$process_type_status = M('process_type_status')->alias("a")
							   ->join("left join ".C('DB_PREFIX')."do_leaves_status b on b.process_type_status_id=a.id")
							   ->join("left join ".C('DB_PREFIX')."admin_user au on au.id=a.checked_user_id")
							   ->field("a.id, a.rank, a.name, ifnull(au.name, au.username) as username, b.status, a.checked_user_id")
							   ->where("b.leaves_id=%d", array($doleave_id))->order("b.id desc")->find();
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
        
        public function get_checked_list(){
    	layout(false);
    	header("Content-type: text/html; charset=utf-8");
    	$temporary_status = M('do_leaves_status')->alias("a")
    						->join("left join ".C("DB_PREFIX")."admin_user b on b.id=a.admin_user_id")
    						->join("left join ".C("DB_PREFIX")."process_type_status c on c.id=a.process_type_status_id")
    						->field("a.*, ifnull(b.name, b.username) as username, c.name as status_name")	
    						->where("a.leaves_id=%d", array($_GET['id']))->order("a.create_time asc")->select();
    	$this->assign('doleaves_status', $doleaves_status);
    	$this->display("DoLeaves/_checked_list");
    	exit;
         }
    	//判断否为审核权限
	public function is_checked_power($user_id, $doleaves_id){
		$s = $this->get_status($leaves_id);
		if( $s['checked_user_id']==$user_id ){
			return true;
		}else{
			return false;
		}
	}
}