<?php
namespace Home\Model;
use Home\Model\BaseModel;
class RolesModel extends BaseModel{
	
	protected $tableName = 'roles';
	
	//搜索
	public function search_info( $options=array() ){
		$where = "is_del=0";
		if( !empty($options['key']) ){
			$where .= " and name like '%".$this->str_filter($options['key'])."%'";
		}
		if( !empty($options['deport_id']) ){
			$where .= " and deport_id=".intval($options['deport_id']);
		}
		$options['num'] = isset($options['num'])?intval($options['num']):10;
		$count = $this->where($where)->count();
		$npage = $this->page($count, $options['num']); //$this->page($count, $options['num']);
		$roles = $this->where($where)->limit($npage->firstRow . ',' . $npage->listRows)->select();
		return array('roles'=>$roles, 'show_page'=>$npage->show());
	}
	
	public function create_info($options=array()){
		if( empty($options['deport_id']) ){
			return array('status'=>false, 'msg'=>'请选择部门');
		}
		if( empty($options['name']) ){
			return array('status'=>false, 'msg'=>'请输入角色名称');
		}
		if( empty($options['ids']) || count($options['ids'])==0 ){
			return array('status'=>false, "msg"=>"请选择权限");
		}
		$options['create_time'] = time();
		M()->startTrans();
		$ids = $options['ids'];
		unset($options['ids']);
		$shop_powers = $options['shop_powers'];
		unset($options['shop_powers']);
		$id = $this->add($options);
		if( $id>0 ){
			foreach($ids as $t){
				if(intval($t)){
					$m = M('menus')->where('id=%d', array($t))->find();
					if( $m['parent_id']>0 ){
						$r = M('role_menus')->where("role_id=%d and menus_id=%d", array($id, $m['parent_id']))->find();
						$i = M('role_menus')->add(array('role_id'=>$id, 'menus_id'=>$m['parent_id']));
					}
					$r = M('role_menus')->where("role_id=%d and menus_id=%d", array($id, $t))->find();
					if( !$r ){
						$i = M('role_menus')->add(array('role_id'=>$id, 'menus_id'=>$t));
						if( $i<=0 ){
							M()->rollback();
							return array('status'=>false, "msg"=>"保存出错");
						}
					}
				}
			}
			$f = M('role_shop')->where("role_id=%d", array($id))->delete();
			if($f===false){ M()->rollback(); return array('status'=>false, "msg"=>"保存出错"); }
			foreach($shop_powers as $v){
				if( $v ){
					$i = M('role_menus')->add(array(
							'role_id'=>$id, 'shop_id'=>$shop_id,
							'is_text'=>isset($v['is_text'])?1:0,
							'is_del'=>isset($v['is_del'])?1:0,
							'is_attach'=>isset($v['is_attach'])?1:0
					));
					if( $i<=0 ){
						M()->rollback();
						return array('status'=>false, "msg"=>"保存出错");
					}
				}
			}
			M()->commit();
			return array('status'=>true, 'msg'=>'添加成功');
		}else{
			M()->rollback();
			return array('status'=>false, 'msg'=>"添加失败");
		}
	}
	
	public function update_info($options=array()){
		if( empty($options['deport_id']) ){
			return array('status'=>false, 'msg'=>'请选择部门');
		}
		if( empty($options['name']) ){
			return array('status'=>false, 'msg'=>'请输入角色名称');
		}
		M()->startTrans();
		$ids = $options['ids'];
		$id = $options['id'];
		$attach_power_ids = $options['attach_power_ids'];
		unset($options['attach_power_ids']);
		$options['attach_power_ids'] = implode(',', $attach_power_ids);
		$text_power_ids = $options['text_power_ids'];
		unset($options['text_power_ids']);
		$options['text_power_ids'] = implode(',', $text_power_ids);
		$check_power_ids = $options['check_power_ids'];
		unset($options['check_power_ids']);
		$options['check_power_ids'] = implode(',', $check_power_ids);
		unset($options['id']);
		unset($options['ids']);
		
		$shop_powers = $options['shop_powers'];
		
		unset($options['shop_powers']);
		
		$f = $this->where("id=%d",array($id))->setField($options);
		if( $f!==false ){
			$f = M('role_menus')->where("role_id=%d", array($id))->delete();
			if($f===false){ M()->rollback(); return array('status'=>false, "msg"=>"保存出错"); }
			foreach($ids as $t){
				if(intval($t)){
					$i = M('role_menus')->add(array('role_id'=>$id, 'menus_id'=>$t));
					if( $i<=0 ){
						M()->rollback();
						return array('status'=>false, "msg"=>"保存出错");
					}
				}
			}
			$f = M('role_shop')->where("role_id=%d", array($id))->delete();
			if($f===false){ M()->rollback(); return array('status'=>false, "msg"=>"保存出错"); }
			foreach($shop_powers as $v){

				if( $v ){
					$i = M('role_shop')->add(array(
							'role_id'=>$id, 'shop_id'=>$v['shop_id'],
							'is_edit'=>isset($v['is_edit'])?1:0,
							'is_send'=>isset($v['is_send'])?1:0,
							'is_del'=>isset($v['is_del'])?1:0
					));
					if( $i<=0 ){
						M()->rollback();
						return array('status'=>false, "msg"=>"保存出错");
					}
				}
			}
			
			M()->commit();
			return array('status'=>true, 'msg'=>"修改成功");
		}else{
			M()->rollback();
			return array('status'=>false, 'msg'=>"修改失败");
		}
	}
	
	public function deport_name($id){
		$deport =M('deport')->where('id=%d', array($id))->find();
		return $deport['name'];
	}
	
	public function user_list($id){
		$users =M('admin_user')->where('deport_id=%d', array($id))->select();
		$arrs = array();
		foreach($users as $value){
			array_push($arrs, $value['name']);
		}
		return implode(",", $arrs);
	}
	
	public function get_roles_options($deport_id=0){
		if( intval($deport_id)>0 ){
			$roles = $this->where("is_del=0 and deport_id=%d", array($deport_id))->select();
		}else{
			$roles = $this->where("is_del=0")->select();
		}
		return $roles;
	}
	
	public function get_username($admin_user_id){
		$user = M('admin_user')->where("id=%d", array($admin_user_id))->find();
		return $user['name'];
	}
	
	public function get_permession_list($role_id){
		$menus = M('menus')->alias('a')->join("left join ".C('DB_PREFIX')."role_menus b on b.menus_id=a.id")
				 ->where("b.role_id=%d", array($role_id))->select();
		$arr_names = array();
		foreach($menus as $v){
			array_push($arr_names, $v['name']);
		}
		return implode(",", $arr_names);
	}
	
	public function is_power($controller_name, $action_name, $user_id){
		$r = M('role_menus')->alias('a')->join('left join '.C('DB_PREFIX')."menus b on b.id=a.menus_id ".
						"left join ".C('DB_PREFIX')."admin_user au on au.role_id=a.role_id")
			 ->where("b.controller_name='%s' and b.action_name='%s' and au.id=%d", array($controller_name, $action_name, $user_id))
			 ->find();
		if($r || $user_id == 1){
			return true;
		}else{
			return false;
		}
	}
	
	public function attach_power($role_id, $id){
		$role = M('roles')->where('id=%d', array($role_id))->find();
		$ids = explode(",", $role['attach_power_ids']);
		if( in_array($id, $ids) ){
			return true;
		}else{
			return false;
		}
	}
	
	public function text_power($role_id, $id){
		$role = M('roles')->where('id=%d', array($role_id))->find();
		$ids = explode(",", $role['text_power_ids']);
		if( in_array($id, $ids) ){
			return true;
		}else{
			return false;
		}
	}
	
	public function check_power($role_id, $id){
		$role = M('roles')->where('id=%d', array($role_id))->find();
                $ids = explode(",", $role['check_power_ids']);
		if( in_array($id,$ids) ){
			return true;
		}else{
			return false;
		}
	}
	
	public function is_shop_edit($shop_id, $role_id){
		$role = M('role_shop')->where("shop_id=%d and role_id=%d and is_edit=1", array($shop_id, $role_id))->find();
		if( $role ){
			return true;
		}else{
			return false;
		}
	}
	public function is_shop_send($shop_id, $role_id){
		$role = M('role_shop')->where("shop_id=%d and role_id=%d and is_send=1", array($shop_id, $role_id))->find();
		if( $role ){
			return true;
		}else{
			return false;
		}
	}
	
	public function is_shop_del($shop_id, $role_id){
		$role = M('role_shop')->where("shop_id=%d and role_id=%d and is_del=1", array($shop_id, $role_id))->find();
		if( $role ){
			return true;
		}else{
			return false;
		}
	}
	
}