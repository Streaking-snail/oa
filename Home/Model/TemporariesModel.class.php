<?php
namespace Home\Model;
use Home\Model\BaseModel;
class TemporariesModel extends BaseModel{
	
	protected $tableName = 'temporaries';
	//搜索
	public function search_info( $options=array() ){
		$where = "a.is_del=0";
		if( !empty($options['key']) ){
			$where .= " and (a.no like '%".$this->str_filter($options['key'])."%'";
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
		$num = isset($options['num'])?intval($options['num']):1;
		$count = $this->alias("a")->where($where)->count();
		$npage = $this->page($count, $num);
		$temporaries = $this->alias("a")->field("a.*, ifnull(b.name, b.username) as name, ifnull(c.name, c.username) as make_name")
						->join("left join ".C('DB_PREFIX')."admin_user b on b.id=a.admin_user_id ")
						->join("left join ".C('DB_PREFIX')."admin_user c on c.id=a.make_id ")
						->where($where)->order("a.create_time desc")
						->limit($npage->firstRow . ',' . $npage->listRows)->select();
		return array('temporaries'=>$temporaries,'show_page'=>$npage->show(),'now_page'=>$npage->firstRow);
	}
	
	
	
	//添加
	public function create_info( $options=array() ){
        $res = $this->valid($options);
        if( !$res['status'] ){ return $res; }
		M()->startTrans();
		$options['report_time'] = strtotime($options['report_time']);
		$options['create_time'] = time();
		$options['admin_user_id'] = $_SESSION['admin_user_id'];
		$id = M('temporaries')->add($options);
		if( $id>0 ){
			M()->commit();
			return array('status'=>true, 'msg'=>'添加成功');
		}else{
			M()->rollback();
			return array('status'=>false,'msg'=>'添加失败');
		}
	}
	
	//修改
	public function update_info( $options=array() ){
            $res = $this->valid($options);
            if(!$res['status']) return $res;
            $id = $options['id'];
            unset($options['id']);
            M()->startTrans();
            $options['report_time'] = strtotime($options['report_time']);
            $f = M('temporaries')->where("id=%d", array($id))->setField($options);
            if( $f!==false ){
                    M()->commit();
                    return array('status'=>true, 'msg'=>'修改信息成功');
            }else{
                    M()->rollback();
                    return array('status'=>false,'msg'=>'修改失败');
            }
	}
	
	public function valid( $options=array() ){
		if( empty($options['no']) ){
			return array('status'=>false, 'msg'=>"请输入单据号");
		}
		if( empty($options['deport_name'])){
			return array('status'=>false, 'msg'=>"请输入报告递交部门");
		}
		if( empty($options['user_name'])){
			return array('status'=>false, 'msg'=>"请输入报告递交人员");
		}
		if( empty($options['report_time'])){
			return array('status'=>false, 'msg'=>"请输入报告填写时间");
		}
		return array('status'=>true, 'msg'=>'ok');
	}
	
	//获取当前状态
	public function get_local_status( $temporary_id ){
		$process_type_status = M('process_type_status')->alias("a")
							   ->join("left join ".C('DB_PREFIX')."temporaries_status b on b.process_type_status_id=a.id")
							   ->join("left join ".C('DB_PREFIX')."admin_user au on au.id=a.checked_user_id")
							   ->field("a.id, a.rank, a.name, ifnull(au.name, au.username) as username, b.status, a.checked_user_id")
							   ->where("b.temporary_id=%d", array($temporary_id))->order("b.id desc")->find();
		return $process_type_status;
	}
	
	//获取状态内容
	public function get_status($temporary_id){
		$process_type = M('process_types')->where("controller_name='Temporary'")->find();
		$process_type_status = M('process_type_status')->alias("a")
							   ->join("left join ".C('DB_PREFIX')."temporaries_status b on b.process_type_status_id=a.id")
							   ->join("left join ".C('DB_PREFIX')."admin_user au on au.id=a.checked_user_id")
							   ->field("a.id, a.rank, a.name, ifnull(au.name, au.username) as username, b.status, a.checked_user_id")
							   ->where("b.temporary_id=%d", array($temporary_id))->order("b.id desc")->find();
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
	
	public function get_last_checked_name($id){
		$status = M('temporaries_status')->where("temporary_id=%d", array($id))->order("id desc")->find();
		if( $status ){
			return $status['status']==1?"<span style=''>审核中</span>":"<span>审核不通过</span>";
		}else{
			return "未审核";
		}
	}
	
	//判断否为审核权限
	public function is_checked_power($user_id, $temporary_id){
		$s = $this->get_status($temporary_id);
		if( $s['checked_user_id']==$user_id ){
			return true;
		}else{
			return false;
		}
	}
	
}