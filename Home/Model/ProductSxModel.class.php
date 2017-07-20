<?php
namespace Home\Model;
use Home\Model\BaseModel;
class ProductSxModel extends BaseModel{
	
	protected $tableName = 'products';
	//搜索
	public function search_info( $options=array() ){
		$where = "status!=3";
		if( !empty($options['key']) ){
			$where .= " and name like '%".$this->str_filter($options['key'])."%'";
		}
		if( !empty($options['category_id']) ){
			$where .= " and category_id=".intval($options['category_id']);
		}
		if( !empty($options['sub_category_id']) ){
			$where .= " and sub_category_id=".intval($options['sub_category_id']);
		}
		if( !empty($options['number']) ){
			$where .= " and (number like '%".$this->str_filter($options['number'])."%' or code like '%".$this->str_filter($options['number'])."%')";
		}
		$num = isset($options['num'])?intval($options['num']):10;
		$count = $this->where($where)->count();
		$npage = $this->page($count, $num);
		$products = M('product_pic')->where('is_over=1')->order("id")->limit($npage->firstRow . ',' . $npage->listRows)->select();
		return array('products'=>$products,'show_page'=>$npage->show());
	}
	
	//添加
	public function create_info( $options=array() ){
                $options['create_time'] = time();
                $res = $this->valid($options);
		if(!$res['status']) return $res;		
		$options['ptime'] = strtotime($options['ptime']);
		M()->startTrans();
		
		if( isset($options['file']) && empty($options['file']['name']) ){ return array("status"=>false, "msg"=>"请上传商品图片"); }
		include_once SITE_PATH.'/Home/Model/FileUpload.class.php';
		$FileUpload = new \FileUpload();
		$path = $FileUpload->save_file($options['file'], "/uploadfiles/products/".date('Y-m-d')."/");
//         $product_attach_id =M('product_attach')->add(array(
//         		'product_id'=>$product_id, 'admin_user_id'=>$options['admin_user_id'],
//         		'create_time'=>time(), 'url'=>$path, 'name'=>$options['file']['name']
//         ));
		$options['pic_path'] = $path;
		$product_id = M('products')->add($options);
                unset($options['file']);
        
		
		if( $product_id>0 ){
			M()->commit();
			return array('status'=>true, 'msg'=>'添加成功');
		}else{
			M()->rollback();
			return array('status'=>false,'msg'=>'添加失败');
		}
	}
	
	//修改
	public function update_info( $options=array() ){
            $res = $this->valid($options);
            if(!$res['status']) return $res;
            $id = $options['id'];
            unset($options['id']);
            M()->startTrans();
            if( isset($options['file']) && !empty($options['file']) && !empty($options['file']['name']) ){
                    M('product_attach')->where("product_id=%d", array($id))->delete();
                    include_once SITE_PATH.'/Home/Model/FileUpload.class.php';
                    $FileUpload = new \FileUpload();
                    $path = $FileUpload->save_file($options['file'], "/uploadfiles/products/".date('Y-m-d')."/");
// 			$product_attach_id = M('product_attach')->add(array(
// 					'product_id'=>$id, 'admin_user_id'=>$options['admin_user_id'],
// 					'create_time'=>time(), 'url'=>$path, 'name'=>$options['file']['name']
// 			));
                    $options['pic_path'] = $path;
                    unset($options['file']);
            }
            unset($options['admin_user_id']);
            $options['status'] = 0;
            $options['ptime'] = strtotime($options['ptime']);
            $f = M('products')->where("id=%d", array($id))->setField($options);
            if( $f!==false ){
                    M()->commit();
                    return array('status'=>true, 'msg'=>'修改信息成功');
            }else{
                    M()->rollback();
                    return array('status'=>false,'msg'=>'修改失败');
            }
	}
	
	public function valid( $options=array() ){
		if( intval($options['category_id'])<=0 ){
			return array('status'=>false, 'msg'=>"请选择大类");
		}
		if( intval($options['sub_category_id'])<=0 ){
			return array('status'=>false, 'msg'=>"请选择产品系列");
		}
		if( empty($options['code']) ){
			return array('status'=>false, 'msg'=>"请输入物料代码");
		}
		if( empty($options['number']) ){
			return array('status'=>false, 'msg'=>"请输入辅代码");
		}
		if( empty($options['name']) ){
			return array('status'=>false, 'msg'=>"请输入产品名称");
		}
		if( doubleval($options['now_price'])<=0 ){
			return array('status'=>false, 'msg'=>"请输入正确的现价");
		}
		if( doubleval($options['sold_price'])<=0 ){
			return array('status'=>false, 'msg'=>"请输入正确的售价");
		}
		if( intval($options['min_num'])<=0 ){
			return array('status'=>false, 'msg'=>"请输入正确的起订量");
		}
		if( empty($options['ptime']) ){
			return array('status'=>false, 'msg'=>"请输入生产周期");
		}
		return array('status'=>true, 'msg'=>'ok');
	}
	
	public function get_category_name($category_id){
		$category = M('category')->where("id=%d", array($category_id))->find();
		return $category['name'];
	}
	
	public function get_sub_category_name($sub_category_id){
		$sub_category = M('sub_category')->where("id=%d", array($sub_category_id))->find();
		return $sub_category['name'];
	}
	
}