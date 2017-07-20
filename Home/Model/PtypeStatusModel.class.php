<?php
namespace Home\Model;
use Home\Model\BaseModel;
class PtypeStatusModel extends BaseModel{
	
	protected $tableName = 'ptype_menus';
	
	public function search_info( $options=array() ){
		$where = "is_del=0";
		if( isset($options['key']) && !empty($options['key']) ){
			$where .= " name like '%".$this->str_filter($options['key'])."%'";
		}
		$options['num'] = isset($options['num'])?intval($options['num']):10;
		$count = $this->where($where)->count();
		$npage = $this->page($count, $options['num']);
		$ptypes = $this->where($where)->limit($npage->firstRow . ',' . $npage->listRows)->select();
		return array('ptypes'=>$ptypes, 'show_page'=>$npage->show());
	}
	
	public function create_info( $options=array() ){
		
	}
	
}