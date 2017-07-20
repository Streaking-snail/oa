<?php
namespace Home\Model;
use Home\Model\BaseModel;
class MenusModel extends Model{
	
	protected $tableName = 'menus';
	
	public function get_menus(){
		$menus = array(
			array('name'=>'首页', 'sub_menus'=>array(), 'controller_name'=>'Index', 'action_name'=>'index'),
			array('name'=>'基础配置', 'sub_menus'=>array(
					array('name'=>'部门管理', 'sub_menus'=>array(
							array('name'=>"部门列表", "controller_name"=>'Deport', 'action_name'=>'index'),
							array('name'=>"添加部门", "controller_name"=>'Deport', 'action_name'=>'add_info'),
					), 'controller_name'=>''),
					array('name'=>'角色管理', 'sub_menus'=>array(
							array('name'=>"角色列表", "controller_name"=>'Role', 'action_name'=>'index'),
							array('name'=>"添加角色", "controller_name"=>'Role', 'action_name'=>'add_info'),
					), 'controller_name'=>''),
					array('name'=>'用户管理', 'sub_menus'=>array(
							array('name'=>"用户列表", 'controller_name'=>'AdminUser', 'action_name'=>'index'),
							array('name'=>"添加用户", 'controller_name'=>'AdminUser', 'action_name'=>"add_info"),
					), 'controller_name'=>''),
					array('name'=>'菜单管理', 'sub_menus'=>array(), 'controller_name'=>'Menus'),
				), 'controller_name'=>'', 'action_name'=>''
		    ),
			
		);
		return $menus;
	}
	
	public function search(){
		
	}
	
	public function create_info(){
		
	}
	
	public function update_info(){
		
	}
	
}