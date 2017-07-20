<?php
namespace Home\Model;
use Home\Model\BaseModel;
class SubCategoryModel extends BaseModel{
	
	protected $tableName = 'sub_category';
	
	//搜索
	public function search_info( $options=array() ){
		$where = "is_del=0";
		if( !empty($options['key']) ){
			$where .= " and name like '%".$this->str_filter($options['key'])."%'";
		}
		if( !empty($options['category_id']) ){
			$where .= " and category_id=".intval($options['category_id']);
		}
		$num = isset($options['num'])?intval($options['num']):10;
		$count = $this->where($where)->count();
		$npage = $this->page($count, $num);
		$sub_categories = $this->where($where)->order("rank,id")->limit($npage->firstRow . ',' . $npage->listRows)->select();
		return array('sub_categories'=>$sub_categories,'show_page'=>$npage->show());
	}
	
	//修改
	public function create_info( $options=array() ){
		$res = $this->valid($options);
		if(!$res['status']) return $res;
		$options['create_time'] = time();
		$id = M('sub_category')->add($options);
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
		$f = M('sub_category')->where("id=%d", array($id))->setField($options);
		if( $f!==false ){
			return array('status'=>true, 'msg'=>'修改信息成功');
		}else{
			return array('status'=>false,'msg'=>'修改失败');
		}
	}
	
	public function valid( $options=array() ){
		if( empty($options['name']) ){
			return array('status'=>false, 'msg'=>"请输入系列名称");
		}
		return array('status'=>true, 'msg'=>'ok');
	}
	
	public function get_category_name($category_id){
		$category = M('category')->where("id=%d", array($category_id))->find();
		return $category['name'];
	}
        public function get_category_options(){
		$categories = M('sub_category')->where('is_del=0')->order('rank')->select();
		array_unshift($categories, array('name'=>'全部', 'id'=>0));
		return $categories;
	}
	
}