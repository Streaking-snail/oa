<?php
namespace Home\Model;
use Home\Model\BaseModel;
class AdminUserLogModel extends BaseModel{
	
	protected $tableName = 'admin_user_log';
	
	//获取登录 
	public function add_log($options){
		$options['admin_user_id'] = $_SESSION['admin_user_id'];
		$options['create_time'] = time();
		$id=M('admin_user_log')->add($options);
		return $id;
	}
	
	public function get_product_logs($product_id){
		$admin_user_logs = M('admin_user_log')->where("source_id=%d and ptype='product'", array($product_id))->order("create_time desc")->select();
		return $admin_user_logs;
	}
        
        
}