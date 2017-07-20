<?php
namespace Home\Model;
use Home\Model\BaseModel;
class ProductBaseModel extends BaseModel{
	
	protected $tableName = 'product_base';
	//搜索
	public function search_info( $options=array() ){
		$where = "is_del=0";
		if( !empty($options['key']) ){
			$where .= " and (name like '%".$this->str_filter($options['key'])."%' or number like '%".$this->str_filter($options['key'])."%' or code like '%".$this->str_filter($options['key'])."%')";
		}
		if( !empty($options['category_id']) ){
			$where .= " and category_id=".intval($options['category_id']);
		}
		if( !empty($options['sub_category_id']) ){
			$where .= " and sub_category_id=".intval($options['sub_category_id']);
		}
		if( !empty($options['classification_id']) ){
			$where .= " and classification_id=".intval($options['classification_id']);
		}
                if( !empty($options['code']) ){
                        $where .=" and code like '%".$this->str_filter($options['code'])."%'";  
                }
                if( !empty($options['number']) ){
                        $where .=" and code like '%".$this->str_filter($options['number'])."%'";  
                }
                if( !empty($options['name']) ){
                        $where .=" and code like '%".$this->str_filter($options['name'])."%'";  
                }
                if( !empty($options['sort']) ){
                    if( $options['sort'] == 'now_price_up' ){
                        $sort = "now_price asc";
                    }else if( $options['sort'] == 'now_price_down' ){
                        $sort = "now_price desc";
                    }else if( $options['sort'] == 'ty_price_up' ){
                        $sort = "sold_price asc";
                    }else if( $options['sort'] == 'ty_price_down' ){
                        $sort = "sold_price desc";
                    }else if( $options['sort'] == 'min_price_up' ){
                        $sort = "min_price asc";
                    }else if( $options['sort'] == 'min_price_down' ){
                        $sort = "min_price desc";
                    }else{
                        $sort = "rank,create_time desc";
                    }
                }
                if($options['price1'] || $options['price2']){
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
		$product_bases = $this->where($where)->order($sort)->limit($npage->firstRow . ',' . $npage->listRows)->select();
		return array('product_bases'=>$product_bases,'show_page'=>$npage->show(),'now_page'=>$npage->firstRow);
//                return $this->getLastSql();
	}
	
	//添加
	public function create_info( $options=array() ){
        $res = $this->valid($options);
		if(!$res['status']) return $res;		
		M()->startTrans();
		$options['create_time'] = time();
		$options['admin_user_id'] = $_SESSION['admin_user_id'];
		
		if( isset($options['file']) && empty($options['file']['name']) ){ return array("status"=>false, "msg"=>"请上传商品图片"); }
		include_once SITE_PATH.'/Home/Model/FileUpload.class.php';
		$FileUpload = new \FileUpload();
		$path = $FileUpload->save_file($options['file'], "/uploadfiles/product_base/".date('Y-m-d')."/");
		$options['pic_path'] = $path;
		$product_id = M('product_base')->add($options);
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
			$product_base = M('product_base')->where("id=%d", array($options['id']))->find();
			
            $res = $this->valid($options, $product['status']);
            if(!$res['status']) return $res;
            $id = $options['id'];
            unset($options['id']);
            M()->startTrans();
            if( isset($options['file']) && !empty($options['file']) && !empty($options['file']['name']) ){
                   	include_once SITE_PATH.'/Home/Model/FileUpload.class.php';
                    $FileUpload = new \FileUpload();
                    $path = $FileUpload->save_file($options['file'], "/uploadfiles/product_base/".date('Y-m-d')."/");
                    $options['pic_path'] = $path;
                    unset($options['file']);
            }
            unset($options['admin_user_id']);
            $options['ptime'] = strtotime($options['ptime']);
            
            $f = M('product_base')->where("id=%d", array($id))->setField($options);
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
		return array('status'=>true, 'msg'=>'ok');
	}
	
}