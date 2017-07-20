<?php
namespace Home\Model;
use Home\Model\BaseModel;
class ClassificationModel extends BaseModel{
	
	protected $tableName = 'classification';
	
	//获取登录 
	public function search_info( $options=array() ){
		$where = "is_del=0";
		if( !empty($options['key']) ){
			$where .= " and name like '%".$this->str_filter($options['key'])."%'";
		}
		$num = isset($options['num'])?intval($options['num']):10;
		$count = $this->where($where)->count();
		$npage = $this->page($count, $num);
		$classifications = $this->where($where)->order("rank,id")->limit($npage->firstRow . ',' . $npage->listRows)->select();
		return array('classifications'=>$classifications,'show_page'=>$npage->show());
	}
	
	//修改
	public function create_info( $options=array() ){
		$res = $this->valid($options);
		if(!$res['status']) return $res;
		$options['admin_user_id'] = $_SESSION['admin_user_id'];
		$options['create_time'] = time();
		$id = M('classification')->add($options);
		if( $id>0 ){
			return array('status'=>true, 'msg'=>'添加成功');
		}else{
			return array('status'=>false,'msg'=>'添加失败');
		}
	}
	
	//添加
	public function update_info( $options=array() ){
		$res = $this->valid($options);
		if(!$res['status']) return $res;
		$id = $options['id'];
		unset($options['id']);
		$f = M('classification')->where("id=%d", array($id))->setField($options);
		if( $f!==false ){
			return array('status'=>true, 'msg'=>'修改信息成功');
		}else{
			return array('status'=>false,'msg'=>'修改失败');
		}
	}
	
	public function valid( $options=array() ){
		if( empty($options['name']) ){
			return array('status'=>false, 'msg'=>"请输入类别名称");
		}
		return array('status'=>true, 'msg'=>'ok');
	}
	
	public function get_category_name($sub_category_id){
		$sub_category = M('sub_category')->where("id=%d", array($sub_category_id))->find();
		$category = M('category')->where("id=%d", array($sub_category['category_id']))->find();
		return $category['name'];
	}
}