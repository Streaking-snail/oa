<?php
namespace Home\Model;
use Home\Model\BaseModel;
class MallModel extends BaseModel{
	
	protected $tableName = 'mall';
	
	public function search_info( $options=array() ){
		if( isset($options['is_del']) ){
			$where = "is_del=1";
		}else{
			$where = "is_del=0";
		}
		if( !empty($options['key']) ){
			$where .= " and (name like '%".$this->str_filter($options['key'])."%' or number like '%".$this->str_filter($options['key'])."%')";
		}
		if( intval($options['status'])>0 ){
			$where .= " and status=".intval($options['status']);
		}
		if( isset($options['deport_id']) && intval($options['deport_id'])>0 ){
			$where .= " and deport_id=".intval($options['deport_id']);
		}
		if( isset($options['is_over']) && intval($options['is_over'])!=1 ){
			$where .= " and is_over=0";
		}
		$num = isset($options['num'])?intval($options['num']):10;
		$count = $this->where($where)->count();
		$npage = $this->page($count, $num);
		$mall = $this->where($where)->limit($npage->firstRow . ',' . $npage->listRows)->select();
		return array('mall'=>$mall,'show_page'=>$npage->show());
	}
	
	public function create_info( $options=array() ){
        $res = $this->valid($options);
		if(!$res['status']){ return $res; }
		$arr_status = $options['detail'];
		unset($options['detail']);
		M()->startTrans();
		$options['create_time'] = time();
        $id = M('mall')->add($options);
		if( $id>0 ){
			foreach($arr_status as $value){
               if($value['or']==0){
					$p_id = M('mall_colums')->add(array('mall_id'=>$id, 'name'=>$value['name'],'ptype_status_id'=>$value['or']));	
					if( $p_id<=0 ){
						M()->rollback();
						return array('status'=>false, "msg"=>"添加失败");
					}
               }else if($value['or']==10){
                    $name = "到货时间";
                    $p_id = M('mall_colums')->add(array('mall_id'=>$id,'name'=>$name,'ptype_status_id'=>$value['or']));
                    if( $p_id<=0 ){
						M()->rollback();
						return array('status'=>false, "msg"=>"添加失败");
					}
                }else{
                    $p_id = M('mall_colums')->add(array('mall_id'=>$id,'ptype_status_id'=>$value['or']));
                    if( $p_id<=0 ){
						M()->rollback();
						return array('status'=>false, "msg"=>"添加失败");
					}
                }
			}
			M()->commit();
			return array('status'=>true, 'msg'=>'添加成功');
		}else{
			M()->rollback();
			return array('status'=>false, "msg"=>"添加失败");
		}
            
	}
	
	public function update_info( $options=array() ){
        $res = $this->valid($options);
		if(!$res['status']){ return $res; }
		$arr_status = $options['detail'];
		unset($options['detail']);
		M()->startTrans();
		$id = $options['id'];
		unset($options['id']);
        $f = M('mall')->where("id=%d",array($id))->setField($options);
		if( $f!==false ){
			//$f = M('mall_colums')->where("mall_id=%d", array($id))->delete();
			//if( $f!==false ){
				foreach($arr_status as $value){
					  $is_text = isset($value['is_text'])?1:0;
					  $is_attach = isset($value['is_attach'])?1:0;
					  if( intval($value['cid'])>0 ){
					  	$t = M('mall_colums')->where("id=%d", array($value['cid']))->setField(array(
					  			'is_text'=>$is_text, 'is_attach'=>$is_attach,
					  			'mall_id'=>$id, 'rank'=>$value['rank'], 'name'=>$value['name'],
					  			'ptype_status_id'=>$value['id']));
					  	if( $t===false ){
					  		M()->rollback();
					  		return array('status'=>false, "msg"=>"修改失败");
					  	}
					  }else{
	                      $p_id = M('mall_colums')->add(array('is_text'=>$is_text, 'is_attach'=>$is_attach,
	                      			'mall_id'=>$id, 'rank'=>$value['rank'], 'name'=>$value['name'],
	                      			'ptype_status_id'=>$value['id']));	
	                      if( $p_id<=0 ){
	                           M()->rollback();
	                           return array('status'=>false, "msg"=>"修改失败");
	                      }
					  }
                }
                M()->commit();
                return array('status'=>true, 'msg'=>'修改成功');
			//}
		}
		M()->rollback();
		return array('status'=>false, "msg"=>"修改失败");
	}
	
	public function valid($options=array()){
		if( empty($options['name']) ){
			return array('status'=>false, 'msg'=>'商城名称');
		}
		return array('status'=>true, 'msg'=>'ok');
	}
	
	//获取项目状态信息
	public function get_status($id){
		$status = M('item_status')->where("item_id=%d", array($id))->select();
		return $status['name'];
	}
	
	//统计中心
	public function total_count_info(){
		$d_count = M('mall')->where("is_del=1")->count();                //已经删除项目数量
		$total_count = M('mall')->where("is_del=0")->count();            //总项目数
		$s_count = M('mall')->where("is_del=0 and is_over=1")->count();  //完成项目数
		$n_count = M('mall')->where("is_del=0 and is_over=0")->count();  //未完成项目数
		
		$start_time = strtotime(date("Y-m-d 00:00:00"));
		$end_time = strtotime(date("Y-m-d 23:59:59"));
		$today_count = M('mall')->where("is_del=0 and (create_time<=%d and create_time>=%d)",array($start_time, $end_time))->count();
		
		return array('d_count'=>$d_count, 's_count'=>$s_count, 'n_count'=>$n_count, 
					 'today_count'=>$today_count, 'total_count'=>$total_count);
	}
	
	public function get_status_info($item_id){
		$item_status = M('item_status')->alias('a')->join("left join ".C('DB_PREFIX')."ptype_status b on b.id=a.ptype_status_id".
														  " left join ".C('DB_PREFIX')."admin_user u on u.id=a.admin_user_id")
					   ->field("a.*, b.name as status_name, ifnull(u.name, u.username) as username")
					   ->where("a.item_id=%d", array($item_id))->order("a.id desc")->find();
		return $item_status;
	}
	
	//获取数据
	public function get_items( $ptype_id ){
		$items = M('items')->where("is_over=0 and ptype_id=%d", array($ptype_id))->select();
		return $items;
	}
	
	public function get_username($admin_user_id){
		$admin_user = M('admin_user')->where("id=%d", array($admin_user_id))->find();
		return $admin_user['name'];
	}
	
	public function get_show_status($item_id, $status_id){
		$item_status = M('item_status')->alias('a')->join("left join ".C('DB_PREFIX')."admin_user b on b.id=a.admin_user_id")
					   ->field("ifnull(b.name, b.username) as username, a.create_time, a.is_over")
					   ->where("a.item_id=%d and a.ptype_status_id=%d", array($item_id, $status_id))->find();
		if( $item_status && $item_status['is_over']==2 ){
			return array('status'=>2, 'msg'=>$item_status['username']."<br />".date("Y-m-d H:i:s",$item_status['create_time']));
		}else if( $item_status && $item_status['is_over']==0 ){
			return array('status'=>0, 'msg'=>$item_status['username']."<br />".date("Y-m-d H:i:s",$item_status['create_time']));
		}else if( $item_status && $item_status['is_over']==-1){
			return array('status'=>-1, 'msg'=>$item_status['username']."<br />".date("Y-m-d H:i:s",$item_status['create_time'])."<font style='color:red;'>拒绝</font>");
		}else if( $item_status && $item_status['is_over']==1 ){
			$str = "";
			$t = time()-$status_info['create_time'];
			$d = intval($t/3600/24);
			$h = intval($t/3600%24);
			$m = intval($t%3600/60);
			$s = intval($t%3600%60);
			$str = "";
			if( $d>0 ){
				$str .= $d."天";
			}
			if( $h>0 ){
				$str .= $h."小时";
			}
			if( $m>0 ){
				$str .= $m."分";
			}
			if( $s>0 ){
				$str .= $s."秒";
			}
			return array('status'=>1, 'msg'=>$item_status['username']."<br />".$str);
		}else{
			return array('status'=>4, "msg"=>'');
		}
	}
	
	public function get_attaches($item_id, $ptype_status_id){
		$item_status = M('item_status')->where("item_id=%d and ptype_status_id=%d", array($item_id, $ptype_status_id))->find();
		if( $item_status ){
			$item_attaches = M('items_attach')->alias("a")->join("left join ".C('DB_PREFIX')."admin_user u on u.id=a.admin_user_id")
						   ->field("ifnull(u.name, u.username) as username, a.create_time, a.name, a.durl")
						  ->where("item_id=%d and item_status_id=%d", array($item_id,$item_status['id']))->select();
			return $item_attaches;
		}else{
			return array();
		}
	}
        
        public function get_column_names($id){
           $mall_columns = M('mall_colums')->alias("a")->join("left join ".C('DB_PREFIX')."ptype_status b on b.id=a.ptype_status_id")
                            ->field("if(a.ptype_status_id=10, '到货时间', if(a.ptype_status_id=0,a.name, b.name)) as name, a.ptype_status_id")          
                            ->where('a.mall_id=%d',array($id))->select();
           return $mall_columns;
        }
        
        
    public function get_mall_options(){
    	$malls = M("mall")->where("is_del=0")->select();
    	array_unshift($malls, array('name'=>'全部', 'id'=>0));
    	return $malls;
    }
    
    public function add_first_status($count_info_id, $mall_id){
    	$count = M('count_info_status')->where("count_info_id=%d", array($count_info_id))->count();
    	if( $count==0 ){
    		$mall_colums = M("mall_colums")->where("mall_id=%d and ptype_status_id=0", array($mall_id))->order("rank asc,id")->find();
    		if( $mall_colums ){
    			M('count_info_status')->add(array("count_info_id"=>$count_info_id, "mall_status_id"=>$mall_colums['id'], 'create_time'=>time()));
    		}
    	}
    }
}