<?php
namespace Home\Model;
use Home\Model\BaseModel;
class DoPromotionModel extends BaseModel{
	
	protected $tableName = 'do_promotions';
	
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
			$where .= " and a.send_time>=".strtotime($options['time1']);
		}
		if( !empty($options['time2']) ){
			$where .= " and a.send_time<=".strtotime($options['time2']);
		}
		if( !empty($options['time3']) ){
			$where .= " and a.promotion_start_time>=".strtotime($options['time3']);
		}
		if( !empty($options['time4']) ){
			$where .= " and a.promotion_end_time<=".strtotime($options['time4']);
		}
		$options['num'] = isset($options['num'])?intval($options['num']):10;
		$count = $this->alias("a")->where($where)->count();
		$page = $this->page($count, $options['num']);
		$seach =M('do_promotions');
		$dopromotion = $seach->alias("a")->join("left join ".C("DB_PREFIX")."admin_user b on b.id=a.admin_user_id")
		->join("left join ".C("DB_PREFIX")."deport c on c.id=a.deport_id")
		->field("a.*,ifnull(b.name, b.username) as username,c.name as deport_name")
		->where($where)->limit($page->firstRow . ',' . $page->listRows)->select();
		return array('do_promotion'=>$dopromotion, 'show_page'=>$page->show());
	}
	
	public function create_info($options=array()){

		$res = $this->valid($options);
		
		if(!$res['status']) return $res;
		$options['rank'] = isset($options['rank'])?intval($options['rank']):0;
		$options['promotion_start_time'] = strtotime($options['promotion_start_time']);
		$options['promotion_end_time'] = strtotime($options['promotion_end_time']);
		$options['send_time'] = strtotime($options['send_time']);
		$options['ht_time'] = strtotime($options['ht_time']);
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
		$options['promotion_start_time'] = strtotime($options['promotion_start_time']);
		$options['promotion_end_time'] = strtotime($options['promotion_end_time']);
		$options['send_time'] = strtotime($options['send_time']);
		$options['ht_time'] = strtotime($options['ht_time']);
		$options['rank'] = isset($options['rank'])?intval($options['rank']):0;
		$id = $options['id'];
		unset($options['id']);
		$f = M('do_promotions')->where("id=%d",array($id))->setField($options);
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
	public function get_status($do_promotion_id){
		$process_type = M('process_types')->where("controller_name='DoPromotions'")->find();
		$process_type_status = M('process_type_status')->alias("a")
							   ->join("left join ".C('DB_PREFIX')."do_promotion_status b on b.process_type_status_id=a.id")
							   ->join("left join ".C('DB_PREFIX')."admin_user au on au.id=a.checked_user_id")
							   ->field("a.id, a.rank, a.name, ifnull(au.name, au.username) as username, b.status, a.checked_user_id")
							   ->where("b.do_promotion_id=%d", array($do_promotion_id))->order("b.id desc")->find();
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
		$status = M('do_promotion_status')->where("do_promotion_id=%d", array($id))->order("id desc")->find();
		if( $status ){
			return $status['status']==1?"<span style=''>审核中</span>":"<span>审核不通过</span>";
		}else{
			return "未审核";
		}
	}
	
	public function get_last_checked_name($id){
		$status = M('do_promotion_status')->where("do_promotion_id=%d", array($id))->order("id desc")->find();
		if( $status ){
			return $status['status']==1?"<span style=''>审核中</span>":"<span>审核不通过</span>";
		}else{
			return "未审核";
		}
	}
        
        //获取当前状态
	public function get_local_status( $do_promotion_id ){
		$process_type_status = M('process_type_status')->alias("a")
							   ->join("left join ".C('DB_PREFIX')."do_promotion_status b on b.process_type_status_id=a.id")
							   ->join("left join ".C('DB_PREFIX')."admin_user au on au.id=a.checked_user_id")
							   ->field("a.id, a.rank, a.name, ifnull(au.name, au.username) as username, b.status, a.checked_user_id")
							   ->where("b.do_promotion_id=%d", array($do_promotion_id))->order("b.id desc")->find();
		return $process_type_status;
	}
        
        //判断否为审核权限
	public function is_checked_power($user_id, $do_promotion_id){
		$s = $this->get_status($do_promotion_id);
		if( $s['checked_user_id']==$user_id ){
			return true;
		}else{
			return false;
		}
	}
	
//	function getRandomArray($arr,$num){ //新建一个数组,将传入的数组复制过来,用于运算,而不要直接操作传入的数组; 
	//	var temp_array = new Array(); for (var index in arr) { temp_array.push(arr[index]); } //取出的数值项,保存在此数组 var return_array = new Array(); for (var i = 0; i<num; i++) { //判断如果数组还有可以取出的元素,以防下标越界 if (temp_array.length>0) { //在数组中产生一个随机索引 var arrIndex = Math.floor(Math.random()*temp_array.length); //将此随机索引的对应的数组元素值复制出来 return_array[i] = temp_array[arrIndex]; //然后删掉此索引的数组元素,这时候temp_array变为新的数组 temp_array.splice(arrIndex, 1); } else { //数组中数据项取完后,退出循环,比如数组本来只有10项,但要求取出20项. break; } } return return_array; }
}