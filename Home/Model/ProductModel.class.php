<?php
namespace Home\Model;
use Home\Model\BaseModel;
class ProductModel extends BaseModel{
	
	protected $tableName = 'products';
	//搜索
	public function search_info( $options=array() ){
		$where = "status!=3";
		if( !empty($options['key']) ){
			$where .= " and (name like '%".$this->str_filter($options['key'])."%' or number like '%".$this->str_filter($options['key'])."%' or code like '%".$this->str_filter($options['key'])."%')";
		}
		if( !empty($options['category_id']) ){
			$where .= " and category_id=".intval($options['category_id']);
		}
		if( !empty($options['sub_category_id']) ){
			$where .= " and sub_category_id=".intval($options['sub_category_id']);
		}
                if( !empty($options['code']) ){
                        $where .=" and code like '%".$this->str_filter($options['code'])."%'";  
                }
                if( !empty($options['number']) ){
                        $where .=" and number like '%".$this->str_filter($options['number'])."%'";  
                }
                if( !empty($options['name']) ){
                        $where .=" and name like '%".$this->str_filter($options['name'])."%'";  
                }
                if( !empty($options['ptime1']) ){
                        $where .=" and ptime >= $options[ptime1]";  
                }
                if( !empty($options['ptime2']) ){
                        $where .=" and ptime <= $options[ptime2]";  
                }
                if($options['price1'] && $options['price2']){
                    if( $options['price']=='now_price'){
                        $where .=" and  now_price between $options[price1] and $options[price2]";
                    }else if( $options['price']=='sold_price'){
                        $where .=" and  sold_price between $options[price1] and $options[price2]";
                    }else if( $options['price']=='min_price'){
                        $where .=" and  min_price between $options[price1] and $options[price2]";
                    }
                }
		$num = isset($options['num'])?intval($options['num']):1;
		$count = $this->where($where)->count();
		$npage = $this->page($count, $num);
		$products = $this->where($where)->order("status asc,rank,id")->limit($npage->firstRow . ',' . $npage->listRows)->select();
		return array('products'=>$products,'show_page'=>$npage->show(),'now_page'=>$npage->firstRow);
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
		$options['pic_path'] = $path;
		$product_id = M('products')->add($options);
        unset($options['file']);
		if( $product_id>0 ){
			$product_base = M('product_base')->where("code='%s'", array($options['code']))->find();
			if( !$product_base ){
				$f = M('product_base')->add(array(
					"name"=>$options['name'], "code"=>$options['code'], "number"=>$options['number'], "min_price"=>$options['min_price'],
					"create_time"=>time(), "admin_user_id"=>$_SESSION['admin_user_id'],	'pic_path'=>$options['pic_path'],
					"category_id"=>$options['category_id'], 'sub_category_id'=>$options['sub_category_id'], 
					'classification_id'=>$options['classification_id'],
					'sold_price'=>$options['sold_price'], "now_price"=>$options['now_price']));
			}
			M()->commit();
			return array('status'=>true, 'msg'=>'添加成功');
		}else{
			M()->rollback();
			return array('status'=>false,'msg'=>'添加失败');
		}
	}
	
	//修改
	public function update_info( $options=array() ){
			$product = M('products')->where("id=%d", array($options['id']))->find();
			$number = $options['number'];
			if( $product['status']==1 ){
				unset($options['category_id']);
				unset($options['sub_category_id']);
				unset($options['classification_id']);
				unset($options['name']);
				unset($options['code']);
				unset($options['number']);
				$options['admin_user_id'] = $product['admin_user_id'];
				D('AdminUserLog')->add_log(array(
					'ptype'=>'product',
					'source_id' => $product['id'],
					'content'=>json_encode(array('ninfo'=>$options, 'oinfo'=>$product))
				));
				unset($options['admin_user_id']);
			}else{
				$options['status'] = 0;
			}
            $res = $this->valid($options, $product['status']);
            if(!$res['status']) return $res;
            $id = $options['id'];
            unset($options['id']);
            M()->startTrans();
            if( isset($options['file']) && !empty($options['file']) && !empty($options['file']['name']) ){
                    include_once SITE_PATH.'/Home/Model/FileUpload.class.php';
                    $FileUpload = new \FileUpload();
                    $path = $FileUpload->save_file($options['file'], "/uploadfiles/products/".date('Y-m-d')."/");
                    $options['pic_path'] = $path;
                    unset($options['file']);
            }
            unset($options['admin_user_id']);
            $options['ptime'] = strtotime($options['ptime']);
            
            $f = M('products')->where("id=%d", array($id))->setField($options);
            
            M('product_base')->where("number='%s'",array($number))->setField(array(
            	'min_price'=>$options['min_price'], 'now_price'=>$options['now_price'], 'sold_price'=>$options['sold_price'],
            	'code'=>$options['code'], 'update_time'=>time(), 'name'=>$options['name'], 'category_id'=>$options['category_id'],
            	'sub_category_id'=>$options['sub_category_id'], 'ptype_id'=>$options['sub_categories_id']
            ));
            
            if( $f!==false ){
                    M()->commit();
                    return array('status'=>true, 'msg'=>'修改信息成功');
            }else{
                    M()->rollback();
                    return array('status'=>false,'msg'=>'修改失败');
            }
	}
	
	public function valid( $options=array(), $status=0 ){
		if( $status==0 ){
			if( intval($options['category_id'])<=0 ){
				return array('status'=>false, 'msg'=>"请选择大类");
			}
			if( intval($options['sub_category_id'])<=0 ){
				return array('status'=>false, 'msg'=>"请选择产品系列");
			}
			if( intval($options['classification_id'])<=0 ){
				return array('status'=>false, 'msg'=>"请选择产品类别");
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
        
	public function get_classification_name($classification_id){
		$classification = M('classification')->where("id=%d", array($classification_id))->find();
		return $classification['name'];
	}

	/**
	 * 获取产品列表
	 * @param string $where 默认条件为审核通过状态
	 * @param int $type 默认在数组头部插入一个数组--名称
	 */
	public function get_products_list($where = ' status = 1 ' , $type = 0){
        $products = $this->where($where)->select();
        if( $type == 0 ){
            array_unshift($products, array('name'=>'请选择产品', 'id'=>0));
        }
        return $products;
	}
	
}