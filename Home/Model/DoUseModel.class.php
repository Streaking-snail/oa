<?php
namespace Home\Model;
use Home\Model\BaseModel;
class DoUseModel extends BaseModel{
	
	protected $tableName = 'do_uses';
	
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
		$options['num'] = isset($options['num'])?intval($options['num']):10;
		$count = $this->alias("a")->where($where)->count();
		$page = $this->page($count, $options['num']);
		$seach =M('do_uses');
		$douse = $seach->alias("a")->join("left join ".C("DB_PREFIX")."admin_user b on b.id=a.admin_user_id")
		->join("left join ".C("DB_PREFIX")."deport c on c.id=a.deport_id")
		->field("a.*,ifnull(b.name, b.username) as username,c.name as deport_name")
		->where($where)->limit($page->firstRow . ',' . $page->listRows)->select();
		return array('use'=>$douse, 'show_page'=>$page->show());
	}
	
	public function create_info($options=array()){
		$res = $this->valid($options);
		if(!$res['status']) return $res;
		if($options['back']==1){$options['is_back']=1;}
		else{$options['is_return']=1;}
		$options['rank'] = isset($options['rank'])?intval($options['rank']):0;
		$options['start_time'] = strtotime($options['start_time']);
		$options['end_time'] = strtotime($options['end_time']);
		$options['back_time'] = strtotime($options['back_time']);
		$options['create_time'] = strtotime($options['create_time']);
		$id = $this->add($options);
		if( $id>0 ){
			return array('status'=>true, 'msg'=>"添加成功",'id'=>$id);
		}else{
			return array('status'=>false, 'msg'=>"添加失败");
		}
	}
	
	public function create_info_item($options=array(),$douseid,$admin_user_id){
		foreach ($options as $key=>$value){
		$value['do_use_id'] = $douseid;
		$value['create_time'] = time();
		$value['back_time'] = strtotime($value['back_time']);
		$value['admin_user_id'] = $admin_user_id;
		$items =M('do_use_items');
		$id = $items->add($value);
		}
		if( $id>0 ){
			return array('status'=>true, 'msg'=>"领用产品添加成功");
		}else{
			return array('status'=>false, 'msg'=>"领用产品添加失败");
		}
	}
	
	public function update_info($options=array()){
		$res = $this->valid($options);
		if(!$res['status']) return $res;
		if($options['back']==1){
			$options['is_back']=1;
			$options['is_return']=0;
		}else{
			$options['is_return']=1;
			$options['is_back']=0;
		}
		$options['back_time'] = strtotime($options['back_time']);
		$options['create_time'] = strtotime($options['create_time']);
		$options['rank'] = isset($options['rank'])?intval($options['rank']):0;
		$id = $options['id'];
		unset($options['id']);
		$f = M('do_uses')->where("id=%d",array($id))->setField($options);
		if( $f!==false ){
			return array('status'=>true, 'msg'=>"修改成功",'id'=>$id);
		}else{
			return array('status'=>false, 'msg'=>"修改失败");
		}
	}
	
	public function update_info_item($options=array(),$douseid,$admin_user_id){
// 		print_r($douseid);
// 		exit;
		$items =M('do_use_items');
		$d = $items->where("do_use_id=%d",array($douseid))->delete();
		foreach ($options as $key=>$value){
			$value['do_use_id'] = $douseid;
			$value['create_time'] = time();
			$value['back_time'] = strtotime($value['back_time']);
			$value['admin_user_id'] = $admin_user_id;
			$f = $items->add($value);
			//$id = $items->add($value);
		}
		if( $f!==false ){
			return array('status'=>true, 'msg'=>"领用产品添加成功");
		}else{
			return array('status'=>false, 'msg'=>"领用产品添加失败");
		}
	}
	
	public function valid( $options=array() ){
		if( empty($options['no']) ){
			return array('status'=>false, 'msg'=>"请输入单据号");
		}
		return array('status'=>true, 'msg'=>'ok');
	}
	
	//获取状态内容
	public function get_status($douse_id){
		$process_type = M('process_types')->where("controller_name='DoUse'")->find();
		$process_type_status = M('process_type_status')->alias("a")
							   ->join("left join ".C('DB_PREFIX')."do_use_status b on b.process_type_status_id=a.id")
							   ->join("left join ".C('DB_PREFIX')."admin_user au on au.id=a.checked_user_id")
							   ->field("a.id, a.rank, a.name, ifnull(au.name, au.username) as username, b.status, a.checked_user_id")
							   ->where("b.do_use_id=%d", array($douse_id))->order("b.id desc")->find();
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
		$status = M('do_use_status')->where("do_use_id=%d", array($id))->order("id desc")->find();
		if( $status ){
			return $status['status']==1?"<span style=''>审核中</span>":"<span>审核不通过</span>";
		}else{
			return "未审核";
		}
	}
	
	public function get_last_checked_name($id){
		$status = M('do_use_status')->where("do_use_id=%d", array($id))->order("id desc")->find();
		if( $status ){
			return $status['status']==1?"<span style=''>审核中</span>":"<span>审核不通过</span>";
		}else{
			return "未审核";
		}
	}
	
        	//获取当前状态
	public function get_local_status( $douse_id ){
		$process_type_status = M('process_type_status')->alias("a")
							   ->join("left join ".C('DB_PREFIX')."do_use_status b on b.process_type_status_id=a.id")
							   ->join("left join ".C('DB_PREFIX')."admin_user au on au.id=a.checked_user_id")
							   ->field("a.id, a.rank, a.name, ifnull(au.name, au.username) as username, b.status, a.checked_user_id")
							   ->where("b.do_use_id=%d", array($douse_id))->order("b.id desc")->find();
		return $process_type_status;
	}
        
        //判断否为审核权限
	public function is_checked_power($user_id, $douse_id){
		$s = $this->get_status($douse_id);
		if( $s['checked_user_id']==$user_id ){
			return true;
		}else{
			return false;
		}
	}
}