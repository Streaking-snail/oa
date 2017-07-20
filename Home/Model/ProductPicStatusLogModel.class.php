<?php
namespace Home\Model;
use Home\Model\BaseModel;
class ProductPicStatusLogModel extends BaseModel{
	
	protected $tableName = 'product_pic_status_log';
	
	public function create_info($options=array()){
		$options['admin_user_id'] = $_SESSION['admin_user_id'];
		$options['create_time'] = time();
		$id = M('product_pic_status_log')->add($options);
		if( $id>0 ){
			return array('status'=>true, "notice"=>"ok");
		}else{
			return array('status'=>false, "notice"=>"操作失败");
		}
	}
	
}