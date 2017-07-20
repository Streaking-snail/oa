<?php
namespace Home\Model;
use Home\Model\BaseModel;
class DeportModel extends BaseModel{
	
	protected $tableName = 'deport';
	
	//搜索
	public function search_info( $options=array() ){
		$where = "is_del=0";
		if( !empty($options['key']) ){
			$where .= " and name like '%".$this->str_filter($options['key'])."%'";
		}
		$options['num'] = isset($options['num'])?intval($options['num']):10;
		$count = $this->where($where)->count();
		$page = $this->page($count, $options['num']);
		$deports = $this->where($where)->limit($page->firstRow . ',' . $page->listRows)->select();
		return array('deports'=>$deports, 'show_page'=>$page->show());
	}
	
	public function create_info($options=array()){
		if( empty($options['name']) ){
			return array('status'=>false, 'msg'=>'请输入部门名称');
		}
		$options['rank'] = isset($options['rank'])?intval($options['rank']):0;
		$options['create_time'] = time();
		$id = $this->add($options);
		if( $id>0 ){
			return array('status'=>true, 'msg'=>"添加成功");
		}else{
			return array('status'=>false, 'msg'=>"添加失败");
		}
	}
	
	public function update_info($options=array()){
		if( empty($options['name']) ){
			return array('status'=>false, 'msg'=>'请输入部门名称');
		}
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
	
	public function role_list($id){
		$roles =M('roles')->where('deport_id=%d', array($id))->select();
		$arrs = array();
		foreach($roles as $value){
			array_push($arrs, $value['name']);
		}
		return implode(",", $arrs);
	}
	
	public function user_list($id){
		$users =M('admin_user')->where('deport_id=%d', array($id))->select();
		$arrs = array();
		foreach($users as $value){
			array_push($arrs, $value['name']);
		}
		return implode(",", $arrs);
	}
	
	public function get_deports(){
		$deports = M('deport')->where('is_del=0')->order('rank')->select();
		array_unshift($deports, array('name'=>'所有部门', 'id'=>0));
		return $deports;
	}
	
	public function get_deports_options(){
		$deports = M('deport')->where('is_del=0')->order('rank')->select();
		array_unshift($deports, array('name'=>'请选择部门', 'id'=>0));
		return $deports;
	}
	
}