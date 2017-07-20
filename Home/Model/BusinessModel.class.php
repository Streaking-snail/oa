<?php
namespace Home\Model;
use Home\Model\BaseModel;
class BusinessModel extends BaseModel{
	
	protected $tableName = 'businesses';
	
	//搜索
	public function search_info( $options=array() ){
		$where = "a.is_del=0";
		if( !empty($options['key']) ){
			$where .= " and name like '%".$this->str_filter($options['key'])."%'";
		}
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
		if( !empty($options['time1']) ){
			$where .= " and a.input_time>=".strtotime($options['time1']);
		}
		if( !empty($options['time2']) ){
			$where .= " and a.input_time<=".strtotime($options['time2']);
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
		$businesses = $this->alias("a")->join("left join ".C("DB_PREFIX")."admin_user b on b.id=a.admin_user_id")
		->join("left join ".C("DB_PREFIX")."deport c on c.id=a.deport_id")
		->field("a.*,ifnull(b.name, b.username) as username,c.name as deport_name")
		->where($where)->limit($page->firstRow . ',' . $page->listRows)->select();
		return array('businesses'=>$businesses, 'show_page'=>$page->show());
	}
        
     public function show($Tpl_Name = 'default') {
        //当分页数只有1的时候，不显示
        if ($this->Total_Pages <= 1) {
            return;
        }
        return $this->Pager($this->Page_tpl [$Tpl_Name]);
    }
	
	public function create_info($options=array()){
		$options['rank'] = isset($options['rank'])?intval($options['rank']):0;
		$options['start_time'] = strtotime($options['start_time']);
		$options['end_time'] = strtotime($options['end_time']);
		$options['input_time'] = time();
		$id = $this->add($options);
		if( $id>0 ){
			return array('status'=>true, 'msg'=>"添加成功");
		}else{
			return array('status'=>false, 'msg'=>"添加失败");
		}
	}
	
	public function update_info($options=array()){
		$options['start_time'] = strtotime($options['start_time']);
		$options['end_time'] = strtotime($options['end_time']);
		$options['input_time'] = time();
		$options['rank'] = isset($options['rank'])?intval($options['rank']):0;
		$id = $options['id'];
		unset($options['id']);
		$f = $this->where("id=%d",array($id))->setField($options);
		if( $f!==false ){
			return array('status'=>true, 'msg'=>"修改成功");
		}else{
			return array('status'=>false, 'msg'=>"修改失败");
		}
	}
        
        	
	//获取当前状态
	public function get_local_status( $businesses_id ){
		$process_type_status = M('process_type_status')->alias("a")
							   ->join("left join ".C('DB_PREFIX')."businesses_status b on b.process_type_status_id=a.id")
							   ->join("left join ".C('DB_PREFIX')."admin_user au on au.id=a.checked_user_id")
							   ->field("a.id, a.rank, a.name, ifnull(au.name, au.username) as username, b.status, a.checked_user_id")
							   ->where("b.businesses_id=%d", array($businesses_id))->order("b.id desc")->find();
		return $process_type_status;
	}
	
	//获取状态内容
	public function get_status($businesses_id){
		$process_type = M('process_types')->where("controller_name='Business'")->find();
		$process_type_status = M('process_type_status')->alias("a")
							   ->join("left join ".C('DB_PREFIX')."businesses_status b on b.process_type_status_id=a.id")
							   ->join("left join ".C('DB_PREFIX')."admin_user au on au.id=a.checked_user_id")
							   ->field("a.id, a.rank, a.name, ifnull(au.name, au.username) as username, b.status, a.checked_user_id")
							   ->where("b.businesses_id=%d", array($businesses_id))->order("b.id desc")->find();
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
		$status = M('businesses_status')->where("businesses_id=%d", array($id))->order("id desc")->find();
		if( $status ){
			return $status['status']==1?"<span style=''>审核中</span>":"<span>审核不通过</span>";
		}else{
			return "未审核";
		}
	}
	
	public function get_last_checked_name($id){
		$status = M('businesses_status')->where("businesses_id=%d", array($id))->order("id desc")->find();
		if( $status ){
			return $status['status']==1?"<span style=''>审核中</span>":"<span>审核不通过</span>";
		}else{
			return "未审核";
		}
	}
        
        	//判断否为审核权限
	public function is_checked_power($user_id, $business_id){
		$s = $this->get_status($business_id);
		if( $s['checked_user_id']==$user_id ){
			return true;
		}else{
			return false;
		}
	}
        
	
}