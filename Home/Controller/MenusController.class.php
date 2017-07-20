<?php
namespace Home\Controller;
use Common\Common\Controller\AdminBaseController;
class MenusController extends AdminBaseController {
    
	public $locations = array();
	
	function __construct(){
		parent::__construct();
		$this->locations = array(
				array('is_checked'=>true, 'name'=>'菜单管理', 'url'=>U('Menus/index'))
		);
		$this->assign('loc_name_1', "菜单管理");
		$this->assign('locations', $this->locations);
	}
	
	public function index(){
		
		$this->assign("loc_name_2", "菜单列表");
		$s_menus = M('menus')->where("ptype=0")->select();
		foreach($s_menus as $i=>$value){
			$a = M('menus')->where("parent_id=%d", array($value['id']))->select();
			foreach($a as $j=>$val){
				$b = M('menus')->where("parent_id=%d", array($val['id']))->select();
				foreach($b as $k=>$v){
					$c = M('menus')->where("parent_id=%d", array($v['id']))->select();
					foreach($c as $n=>$va){
						$c[$n]['sub_menus'] = M('menus')->where("parent_id=%d", array($va['id']))->select();
					}
					$b[$k]['sub_menus'] = $c;
				}
				$a[$j]['sub_menus'] = $b;
			}
			$s_menus[$i]['sub_menus'] = $a;
		}
		$this->assign('s_menus', $s_menus);
    	$this->display();
    }
    
    public function edit(){
    	$this->assign("loc_name_2", "修改菜单");
    	$menu = M('menus')->where("id=%d", array($_GET['id']))->find();
    	$this->assign('menu', $menu);
    	$this->display();
    }
    
    public function update_info(){
    	if( isset($_POST['menu']) ){
    		$data = $_POST['menu'];
	    	$f = M('menus')->where("id=%d", array($data['id']))
	    				->setField(array('name'=>$data['name'], 'is_show'=>$data['is_show'], 'rank'=>$data['rank']));
	    	if( $f!==false ){
	    		$this->set_notice(1, "修改成功");
	    	}else{
	    		$this->set_notice(2, "修改失败");
	    	}
    	}else{
    		$this->set_notice(2, "参数错误");
    	}
    	$this->redirect("Menus/index");
    }
    
}