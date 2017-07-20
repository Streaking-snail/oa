<?php
namespace Home\Model;
use Home\Model\BaseModel;
class   ShopModel extends BaseModel{
	
	protected $tableName = 'shop';
	
        
        
        
        
        
	//搜索
	public function search_info( $options=array() ){
		if( !empty($options['key']) ){
			$where .= " and name like '%".$this->str_filter($options['key'])."%'";
		}
		$num = isset($options['num'])?intval($options['num']):10;
		$count = $this->where($where)->count();
		$npage = $this->page($count, $num);
		$shop = $this->order("id")->limit($npage->firstRow . ',' . $npage->listRows)->select();
                $mall_name =  M('mall')->where("id=%d",array($shop['mall_id']))->select();
                $shop['mall']=$mall_name['name'];
		return array('shop'=>$shop,'show_page'=>$npage->show());
	}
	
	//新增
	public function create_info( $options=array() ){
		$res = $this->valid($options);
		if(!$res['status']) return $res;
		$options['create_time'] = time();
		$id = M('shop')->add($options);
		if( $id>0 ){
			return array('status'=>true, 'msg'=>'添加成功');
		}else{
			return array('status'=>false,'msg'=>'添加失败');
		}
	}
	
	//修改
	public function update_info( $options=array() ){
		$res = $this->valid($options);
		if(!$res['status']) return $res;
		$id = $options['id'];
		unset($options['id']);
		$f = M('shop')->where("id=%d", array($id))->setField($options);
		if( $f!==false ){
			return array('status'=>true, 'msg'=>'修改信息成功');
		}else{
			return array('status'=>false,'msg'=>'修改失败');
		}
	}
	
	public function valid( $options=array() ){
		if( empty($options['name']) ){
			return array('status'=>false, 'msg'=>"请输入商城名称");
		}
		return array('status'=>true, 'msg'=>'ok');
	}
	
	public function get_category_options(){
		$categories = M('category')->where('is_del=0')->order('rank')->select();
		array_unshift($categories, array('name'=>'全部', 'id'=>0));
		return $categories;
	}
        
        public function get_status($id){
            $id=$id;
            $status = M('count_info_status_attach')->alias('a')->join(
                    "left join ".C('DB_PREFIX')."count_info_status b on a.count_info_status_id=b.id")
                    ->field("b.status")
                    ->where("a.id=%d",$id)->find();
            return $status;
        }
	
}