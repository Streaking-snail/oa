<?php
namespace Home\Model;
use Home\Model\BaseModel;
class ProcessTypeModel extends BaseModel{
	
	protected $tableName = 'process_types';
	//搜索
	public function search_info( $options=array() ){
		$where = "is_del=0";
		if( !empty($options['key']) ){
			$where .= " and name like '%".$this->str_filter($options['key'])."%'";
		}
		$num = isset($options['num'])?intval($options['num']):1;
		$count = $this->where($where)->count();
		$npage = $this->page($count, $num);
		$process_types = $this->where($where)->order("id")->limit($npage->firstRow . ',' . $npage->listRows)->select();
		return array('process_types'=>$process_types,'show_page'=>$npage->show(),'page_number'=>$npage->firstRow);
	}
	
	
	//修改
	public function update_info( $options=array() ){
			$res = $this->valid($options);
            $id = $options['id'];
            unset($options['id']);
            M()->startTrans();
            $options['update_time'] = time();
            $options['update_user_id'] = $_SESSION['admin_user_id'];
            $f = M('process_types')->where("id=%d", array($id))->setField($options);
            if( $f!==false ){
	            	foreach($options['process_type_status'] as $k=>$value){
	            		$admin_user = M('admin_user')->where("username='%s'", array($value['username']))->find();
	            		if( !$admin_user ){
	            			M()->rollback();
	            			return array('status'=>false,'msg'=>'请选择完整审核人员');
	            		}
	            		if( intval($value['id'])==0 ){
		            		$sid = M('process_type_status')->add(array('process_type_id'=>$id,
		            				'checked_user_id'=>$admin_user['id'], 'name'=>$value['name'], 
		            				'rank'=>$value['rank'], 'content'=>$value['content'],
		            				'creat_time'=>time(), 'admin_user_id'=>$_SESSION['admin_user_id']));
		            		if($sid<=0){
		            			M()->rollback();
		            			return array('status'=>false,'msg'=>'添加失败');
		            		}
	            		}else{
	            			$t = M('process_type_status')->where("id=%d", array($value['id']))
	            				 ->setField(array('process_type_id'=>$id,
	            					'checked_user_id'=>$admin_user['id'], 'name'=>$value['name'],
	            					'rank'=>$value['rank'], 'content'=>$value['content'],
	            					'creat_time'=>time(), 'admin_user_id'=>$_SESSION['admin_user_id']));
	            			if($t===false){
	            				M()->rollback();
	            				return array('status'=>false,'msg'=>'添加失败');
	            			}
	            		}
	            	}
                    M()->commit();
                    return array('status'=>true, 'msg'=>'修改信息成功');
            }else{
                    M()->rollback();
                    return array('status'=>false,'msg'=>'修改失败');
            }
	}
	
	public function valid( $options=array(), $status=0 ){
		if( intval($options['name'])<=0 ){
			return array('status'=>false, 'msg'=>"请工作流程名称");
		}
		if( count($options['process_type_status'])==0 ){
			return array('status'=>false, "msg"=>"请补充完整状态");
		}
		foreach($options['process_type_status'] as $value){
			if( empty($value['name']) ){
				return array("status"=>false, "msg"=>"请补充完整状态名称");
			}
			$admin_user = M('admin_user')->where("username='%s'", array($value['username']))->find();
			if( !$admin_user ){
				return array('status'=>false,'msg'=>'请选择审核人员');
			}
			if( empty($value['username']) ){
				return array("status"=>false, "msg"=>"请选择审核人员");
			}
		}
		return array('status'=>true, 'msg'=>'ok');
	}

	public function get_status($process_type_id){
        $process_type_status = M('process_type_status')->where("is_del=0 and process_type_id=%d", array($process_type_id))
        						->order("rank asc,id asc")->select();
        return $process_type_status;
	}
	
	//判断是否有审核权限
	public function is_checked_temporary($user_id, $temporary_id){
		$temporary_status = M('temporaries_status')->alias("a")
							->join("left join ".C('DB_PREFIX')."process_type_status b on b.id=a.status")
							->field("b.id, b.rank")
							->where("a.temporary_id=%d and b.is_del=0", array($temporary_id))->order("a.id desc")->find();
		$process_type_status = M('process_type_status')->where("rank>=%d and id!=%d", array($temporary_status['rank'], $temporary_status['id']))->order("rank asc,id asc")->find();
		return $process_type_status;
	}
}