<?php
namespace Home\Model;
use Home\Model\BaseModel;
class ItemsModel extends BaseModel{
	
	protected $tableName = 'items';
	
	public function search_info( $options=array() ){
		if( isset($options['is_del']) ){
			$where = "is_del=1";
		}else{
			$where = "is_del=0";
		}
		if( !empty($options['key']) ){
			$where .= " and (name like '%".$this->str_filter($options['key'])."%' or number like '%".$this->str_filter($options['key'])."%')";
		}
		if( intval($options['status'])>0 ){
			$where .= " and status=".intval($options['status']);
		}
		if( isset($options['deport_id']) && intval($options['deport_id'])>0 ){
			$where .= " and deport_id=".intval($options['deport_id']);
		}
		if( isset($options['is_over']) && intval($options['is_over'])!=1 ){
			$where .= " and is_over=0";
		}
		$num = isset($options['num'])?intval($options['num']):10;
		$count = $this->where($where)->count();
		$npage = $this->page($count, $num);
		$items = $this->where($where)->limit($npage->firstRow . ',' . $npage->listRows)->select();
		return array('items'=>$items,'show_page'=>$npage->show());
	}
	
	public function create_info( $options=array() ){
		$res = $this->valid($options);
		if( !$res['status'] ){ return $res; }
		$options['create_time'] = time();
		$status = M('ptype_status')->where("ptype_id=%d", array($options['ptype_id']))->order("rank asc,id asc")->find();
		$options['status'] = $status['id'];
		$id = $this->add($options);
		if( $id>0 ){
			$status_id = M('item_status')->add(array('item_id'=>$id, 'create_time'=>$options['create_time'],
					'admin_user_id'=>$options['admin_user_id'], 'ptype_status_id'=>$status['id']
			));
			return array("status"=>true, 'msg'=>"添加项目成功");
		}else{
			return array("status"=>false, 'msg'=>"添加项目失败");
		}
	}
	
	public function update_info( $options=array() ){
		$res = $this->valid($options);
		if( !$res['status'] ){ return $res; }
		$id = $options['id'];
		unset($options['id']);
		$f = $this->where("id=%d", array($id))->setField($options);
		if( $f!==false ){
			return array("status"=>true, 'msg'=>"修改项目信息成功");
		}else{
			return array("status"=>false, 'msg'=>"修改项目信息失败");
		}
	}
	
	public function valid($options=array()){
		if( empty($options['name']) ){
			return array('status'=>false, 'msg'=>'商品名称');
		}
		if( empty($options['number']) ){
			return array('status'=>false, 'msg'=>'商品货号');
		}
		return array('status'=>true, 'msg'=>'ok');
	}
	
	//获取项目状态信息
	public function get_status($id){
		$status = M('item_status')->where("item_id=%d", array($id))->select();
		return $status['name'];
	}
	
	//统计中心
	public function total_count_info(){
		$d_count = M('items')->where("is_del=1")->count();                //已经删除项目数量
		$total_count = M('items')->where("is_del=0")->count();            //总项目数
		$s_count = M('items')->where("is_del=0 and is_over=1")->count();  //完成项目数
		$n_count = M('items')->where("is_del=0 and is_over=0")->count();  //未完成项目数
		
		$start_time = strtotime(date("Y-m-d 00:00:00"));
		$end_time = strtotime(date("Y-m-d 23:59:59"));
		$today_count = M('items')->where("is_del=0 and (create_time<=%d and create_time>=%d)",array($start_time, $end_time))->count();
		
		return array('d_count'=>$d_count, 's_count'=>$s_count, 'n_count'=>$n_count, 
					 'today_count'=>$today_count, 'total_count'=>$total_count);
	}
	
	public function get_status_info($item_id){
		$item_status = M('item_status')->alias('a')->join("left join ".C('DB_PREFIX')."ptype_status b on b.id=a.ptype_status_id".
														  " left join ".C('DB_PREFIX')."admin_user u on u.id=a.admin_user_id")
					   ->field("a.*, b.name as status_name, ifnull(u.name, u.username) as username")
					   ->where("a.item_id=%d", array($item_id))->order("a.id desc")->find();
		return $item_status;
	}
	
	//获取数据
	public function get_items( $ptype_id ){
		$items = M('items')->where("is_over=0 and ptype_id=%d", array($ptype_id))->select();
		return $items;
	}
	
	public function get_username($admin_user_id){
		$admin_user = M('admin_user')->where("id=%d", array($admin_user_id))->find();
		return $admin_user['name'];
	}
	
	public function get_show_status($item_id, $status_id){
		$item_status = M('item_status')->alias('a')->join("left join ".C('DB_PREFIX')."admin_user b on b.id=a.admin_user_id")
					   ->field("ifnull(b.name, b.username) as username, a.create_time, a.is_over")
					   ->where("a.item_id=%d and a.ptype_status_id=%d", array($item_id, $status_id))->find();
		if( $item_status && $item_status['is_over']==2 ){
			return array('status'=>2, 'msg'=>$item_status['username']."<br />".date("Y-m-d H:i:s",$item_status['create_time']));
		}else if( $item_status && $item_status['is_over']==0 ){
			return array('status'=>0, 'msg'=>$item_status['username']."<br />".date("Y-m-d H:i:s",$item_status['create_time']));
		}else if( $item_status && $item_status['is_over']==-1){
			return array('status'=>-1, 'msg'=>$item_status['username']."<br />".date("Y-m-d H:i:s",$item_status['create_time'])."<font style='color:red;'>拒绝</font>");
		}else if( $item_status && $item_status['is_over']==1 ){
			$str = "";
			$t = time()-$status_info['create_time'];
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
			return array('status'=>1, 'msg'=>$item_status['username']."<br />".$str);
		}else{
			return array('status'=>4, "msg"=>'');
		}
	}
	
	public function get_attaches($item_id, $ptype_status_id){
		$item_status = M('item_status')->where("item_id=%d and ptype_status_id=%d", array($item_id, $ptype_status_id))->find();
		if( $item_status ){
			$item_attaches = M('items_attach')->alias("a")->join("left join ".C('DB_PREFIX')."admin_user u on u.id=a.admin_user_id")
						   ->field("ifnull(u.name, u.username) as username, a.create_time, a.name, a.durl")
						  ->where("item_id=%d and item_status_id=%d", array($item_id,$item_status['id']))->select();
			return $item_attaches;
		}else{
			return array();
		}
	}
}