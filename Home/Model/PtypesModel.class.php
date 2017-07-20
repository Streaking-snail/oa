<?php
namespace Home\Model;
use Home\Model\BaseModel;
class PtypesModel extends BaseModel{
	
	protected $tableName = 'ptypes';
	
	public function search_info( $options=array() ){
		$where = "is_del=0";
		if( isset($options['key']) && !empty($options['key']) ){
			$where .= " name like '%".$this->str_filter($options['key'])."%'";
		}
		$options['num'] = isset($options['num'])?intval($options['num']):10;
		$count = $this->where($where)->count();
		$npage = $this->page($count, $options['num']);
		$ptypes = $this->where($where)->limit($npage->firstRow . ',' . $npage->listRows)->select();
		return array('ptypes'=>$ptypes, 'show_page'=>$npage->show());
	}
	
	public function get_ptype_statuses($ptype_id){
		$ptype_statuses = M('ptype_status')->where("ptype_id=%d", array($ptype_id))->order("rank asc,id")->select();
		return $ptype_statuses;
	}
	
	//添加
	public function create_info( $options=array() ){
		$res = $this->valid($options);
		if(!$res['status']){ return $res; }
		$arr_status = $options['ptype_statuses'];
		unset($options['ptype_statuses']);
		M()->startTrans();
		$options['create_time'] = time();
		$id = $this->add($options);
		if( $id>0 ){
			foreach($arr_status as $value){
				$p_id = M('ptype_status')->add(array('ptype_id'=>$id, 'name'=>$value['name'], 'rank'=>$value['rank']));	
				if( $p_id<=0 ){
					M()->rollback();
					return array('status'=>false, "msg"=>"添加失败");
				}
			}
			M()->commit();
			return array('status'=>true, 'msg'=>'添加成功');
		}else{
			M()->rollback();
			return array('status'=>false, "msg"=>"添加失败");
		}
	}
	
	public function update_info( $options=array() ){
		$res = $this->valid($options);
		if(!$res['status']){ return $res; }
		$arr_status = $options['ptype_statuses'];
		unset($options['ptype_statuses']);
		M()->startTrans();
		$id = $options['id'];
		unset($options['id']);
		$f = $this->where("id=%d", array($id))->setField($options);
		if( $f!==false ){
			//$f = M('ptype_status')->where("ptype_id=%d", array($id))->delete();
			//if( $f!==false ){
				foreach($arr_status as $value){
					if( intval($value['id'])>0 ){
						$f = M('ptype_status')->where("id=%d", array($value['id']))->setField(array('name'=>$value['name'], 'rank'=>$value['rank']));
						if( $p_id<=0 ){
							M()->rollback();
							return array('status'=>false, "msg"=>"修改失败");
						}
					}else{
						$p_id = M('ptype_status')->add(array('ptype_id'=>$id, 'name'=>$value['name'], 'rank'=>$value['rank']));
						if( $p_id<=0 ){
							M()->rollback();
							return array('status'=>false, "msg"=>"修改失败");
						}
					}
				}
				M()->commit();
				return array('status'=>true, 'msg'=>'修改成功');
			//}
		}
		M()->rollback();
		return array('status'=>false, "msg"=>"修改失败");
	}
	
	public function valid($options=array()){
		if( empty($options['name']) ){
			return array('status'=>false, "msg"=>"请输入分类名称");
		}
		if( empty($options['ptype_statuses']) || !is_array($options['ptype_statuses']) ){
			return array('status'=>false, "msg"=>"请添加状态");
		}
		return array('status'=>true, 'msg'=>'ok');
	}
	
	public function get_status($id){
		$status = M('ptype_status')->where("ptype_id=%d", array($id))->order("rank asc,id")->select();
		return $status;
	}
	
	public function get_admin_name($admin_user_id){
		$admin_user = M('admin_user')->where("id=%d", array($admin_user_id))->find();
		return $admin_user['name'];
	}
	
	public function get_ptype_options($ptype_id){
		$ptype_statuses = M('ptype_status')->where("ptype_id=%d", array($ptype_id))->field("id as val, name")->select();
		array_unshift($ptype_statuses, array('name'=>'全部', 'id'=>0));
		return $ptype_statuses;
	}
	
}