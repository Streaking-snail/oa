<?php
//基础controller
namespace Common\Common\Controller;
use Think\Controller;
class AdminBaseController extends Controller {
	
	public $skip_filters = array();
	public $user_info, $admin_user_id;
	function __construct() {
		parent::__construct();
		$this->admin_user_id = isset($_SESSION['admin_user_id'])?intval($_SESSION['admin_user_id']):0;
		$this->assign('admin_user_id', $this->admin_user_id);
		//$members = array();
		if( $this->admin_user_id>0 ){
 			$user = M('admin_user')->where('id=%d', array($this->admin_user_id))->find();
			if( $user['is_lock'] ){ 
				$this->set_notice(5, "用户已锁定");
				$this->redirect('Login/index');
			}
			$role = M('roles')->where("id=%d", array($user['role_id']))->find();
			if( $role ){
				$d = M('deport')->where('id=%d',array($role['deport_id']))->find();
				$user['deport_name'] = $d['name'];
			}else{
				$user['deport_name'] = '';
			}
			$this->user_info = $user;
			$this->assign('user_info', $user);
			$this->assign('controller',CONTROLLER_NAME);
			//$members = M('admin_user')->where("id!=%d and deport_id=%d", array($this->admin_user_id, $user['deport_id']))->order("create_time desc")->select();
				
			$admin_user_shows = M('admin_user_show')->where("admin_user_id=%d and is_background=0",array($this->admin_user_id))->select();
			$aus = M('admin_user_show')->where("admin_user_id=%d and is_background=1",array($this->admin_user_id))->find();
			$admin_color = isset($aus['code'])?$aus['code']:'#438EB9';
			$backgrounds = array("#438EB9"=>"no-skin", "#222A2D"=>"skin-1", "#C6487E"=>"skin-2", "#D0D0D0"=>"skin-3");
			$this->assign('admin_user_shows', $admin_user_shows);
			$this->assign('admin_class', $backgrounds[$admin_color]);
			$this->assign('admin_color', $admin_color);
			$time = time()-3600*24*5;
			if( $this->user_info['is_admin']==1 ){
				$msgs = M('deport_message')->alias('a')->join("left join ".C('DB_PREFIX')."admin_user u on u.id=a.admin_user_id")
						->where("a.create_time>=%d", array($time))
						->field("a.msg, a.create_time, ifnull(u.name, u.username) as username, u.head_pic")
				        ->order("a.create_time desc")->limit(5)->select();
			}else{
				$msgs = M('deport_message')->alias('a')->join("left join ".C('DB_PREFIX')."admin_user u on u.id=a.admin_user_id")
					    ->where("a.deport_id=%d and a.create_time>=%d", array($this->user_info['deport_id'],$time))
					    ->field("a.msg, a.create_time, ifnull(u.name, u.username) as username, u.head_pic")
						->order("a.create_time desc")->limit(5)->select();
			}
			$this->assign('last_msgs', $msgs);
		}else{
			if( IS_AJAX ){
				echo '请登录之后再操作';
				exit;
			}else{
				$this->set_notice(5, '请登录');
				$this->redirect('Login/index');
			}
		}
		//$this->assign('members', $members);
		$this->get_menus();
	}
    
	//设置提示码
	public function set_notice($key, $msg){
		$arrs = array(
				1=>'success',   //成功提示样式
				2=>'error',      //错误提示样式
				3=>'warning',     //提醒样式
				4=>'login_index',    //登录首页显示提示
				5=>'login'   //登录页显示提示
		);
		$_SESSION['notice_code']= $arrs[$key];
		$_SESSION['notice'] = $msg;
	}
	
	protected function page($Total_Size = 1, $Page_Size = 0, $Current_Page = 1, $listRows = 6, $PageParam = '', $PageLink = '', $Static = FALSE) {
        import('Page');
        if ($Page_Size == 0) {
            $Page_Size = C("PAGE_LISTROWS");
        }
        if (empty($PageParam)) {
            $PageParam = C("VAR_PAGE");
        }
        $Page = new \Page($Total_Size, $Page_Size, $Current_Page, $listRows, $PageParam, $PageLink, $Static);
        $Page->SetPager('Admin', '{first}{prev}&nbsp;{liststart}{list}{listend}&nbsp;{next}{last}', array("listlong" => "6", "first" => "首页", "last" => "尾页", "prev" => "上一页", "next" => "下一页", "list" => "*", "disabledclass" => ""));
        return $Page;
    }
    
    /**
     * 获取菜单信息
     */
    public function get_menus(){
//     	$menus = array(
//     		array('name'=>'基础配置', 'class_code'=>'desktop', 'sub_menus'=>array(
//     			array('name'=>'部门管理', 'sub_menus'=>array(
//     				array('name'=>'部门列表', 'controller_name'=>'Deport', 'action_name'=>'index', 'url'=>U('Deport/index')),
//     				array('name'=>'添加部门', 'controller_name'=>'Deport', 'action_name'=>'add_info', 'url'=>U('Deport/add_info')),
//     			), 'controller_name'=>'Deport', 'action_name'=>'index', 'url'=>'javascript:void(0);'),
//    				array('name'=>'角色管理','sub_menus'=>array(
//    					array('name'=>'角色列表', 'controller_name'=>'Role', 'action_name'=>'index', 'url'=>U('Role/index')),
//   				    array('name'=>'添加角色', 'controller_name'=>'Role', 'action_name'=>'add_info', 'url'=>U('Role/add_info')),
//    				), 'controller_name'=>'Role', 'action_name'=>'index', 'url'=>'javascript:void(0);'),
//     			array('name'=>'人员管理', 'sub_menus'=>array(
//     					array('name'=>'人员列表', 'controller_name'=>'AdminUser', 'action_name'=>'index', 'url'=>U('AdminUser/index')),
//     					array('name'=>'添加人员', 'controller_name'=>'AdminUser', 'action_name'=>'add_info', 'url'=>U('AdminUser/add_info')),
//     			), 'controller_name'=>'AdminUser', 'action_name'=>'index', 'url'=>'javascript:void(0);'),
//     			array('name'=>'菜单管理', 'sub_menus'=>array(
//     					array('name'=>'菜单列表', 'controller_name'=>'Menus', 'action_name'=>'index', 'url'=>U('Menus/index')),
//     					array('name'=>'添加菜单', 'controller_name'=>'Menus', 'action_name'=>'add_info', 'url'=>U('Menus/add_info')),
//     			), 'controller_name'=>'Menus', 'action_name'=>'index', 'url'=>'javascript:void(0);'),
//     		), 'controller_name'=>'', 'action_name'=>'', 'url'=>'javascript:void(0);'),
//     		array('name'=>"项目管理", 'class_code'=>'list', 'sub_menus'=>array(
//     				array('name'=>'分类管理', 'sub_menus'=>array(
//     						array('name'=>'分类列表', 'controller_name'=>'Ptype', 'action_name'=>'index', 'url'=>U('Ptype/index')),
//     						array('name'=>'添加分类', 'controller_name'=>'Ptype', 'action_name'=>'add_info', 'url'=>U('Ptype/add_info')),
//     				), 'controller_name'=>'Ptypes', 'action_name'=>'index', 'url'=>'javascript:void(0);'),
//     				array('name'=>'项目管理', 'sub_menus'=>array(
//     						array('name'=>'项目列表', 'controller_name'=>'Items', 'action_name'=>'index', 'url'=>U('Items/index')),
//     						array('name'=>'添加项目', 'controller_name'=>'Items', 'action_name'=>'add_info', 'url'=>U('Items/add_info')),
//     				), 'controller_name'=>'Items', 'action_name'=>'', 'url'=>'javascript:void(0);'),
//     		), 'controller_name'=>'Item', 'action_name'=>'', 'url'=>'javascript:void(0);'),
//     	);
//     	$menus = array(
//     			array('name'=>"首页", 'class_code'=>'tachometer', 'controller_name'=>'Index', 'action_name'=>'index', 'url'=>U('Index/index'), 'first_code'=>'hsub', 'second_code'=>"submenu nav-hide"),
//     			array('name'=>'基础配置', 'class_code'=>'list', 'sub_menus'=>array(
//     					array('name'=>'大类列表','sub_menus'=>array(), 'controller_name'=>'Category', 'action_name'=>'index', 'url'=>U('Category/index'), 'first_code'=>'hsub', 'second_code'=>"submenu nav-hide"),
//     					array('name'=>'添加大类', 'sub_menus'=>array(), 'controller_name'=>'Category', 'action_name'=>'add_info', 'url'=>U('Category/add_info'), 'first_code'=>'hsub', 'second_code'=>"submenu nav-hide"),
//     					array('name'=>'产品系列', 'sub_menus'=>array(), 'controller_name'=>'SubCategory', 'action_name'=>'index', 'url'=>U('SubCategory/index'), 'first_code'=>'hsub', 'second_code'=>"submenu nav-hide"),
//     					array('name'=>'添加系列', 'sub_menus'=>array(), 'controller_name'=>'SubCategory', 'action_name'=>'add_info', 'url'=>U('SubCategory/add_info'), 'first_code'=>'hsub', 'second_code'=>"submenu nav-hide"),
//     			), 'controller_name'=>'', 'action_name'=>'', 'url'=>'javascript:void(0);', 'first_code'=>'hsub', 'second_code'=>"submenu nav-hide"),
//     			array('name'=>'产品开发', 'class_code'=>'list', 'sub_menus'=>array(
//     					array('name'=>'产品列表', 'sub_menus'=>array(), 'controller_name'=>'Product', 'action_name'=>'index', 'url'=>U('Product/index'), 'first_code'=>'hsub', 'second_code'=>"submenu nav-hide"),
//     					array('name'=>'新建产品','sub_menus'=>array(), 'controller_name'=>'Product', 'action_name'=>'add_info', 'url'=>U('Product/add_info'), 'first_code'=>'hsub', 'second_code'=>"submenu nav-hide"),
//     			), 'controller_name'=>'', 'action_name'=>'', 'url'=>'javascript:void(0);', 'first_code'=>'hsub', 'second_code'=>"submenu nav-hide"),
//     			array('name'=>"产品下单进度", 'class_code'=>'list', 'sub_menus'=>array(
//     					//array('name'=>'新建项目', 'sub_menus'=>array(), 'controller_name'=>'Items', 'action_name'=>'add_info', "params"=>"ptype_id=2", 'url'=>U('Items/add_info', array('ptype_id'=>2)), 'first_code'=>'hsub', 'second_code'=>"submenu nav-hide"),
//     					array('name'=>'未完成项目','sub_menus'=>array(), 'controller_name'=>'Items', 'action_name'=>'index', "params"=>"ptype_id=2", 'url'=>U('Items/index', array('ptype_id'=>2)), 'first_code'=>'hsub', 'second_code'=>"submenu nav-hide"),
//     					array('name'=>'全部项目', 'sub_menus'=>array(), 'controller_name'=>'Items', 'action_name'=>'list_items', "params"=>"ptype_id=2", 'url'=>U('Items/list_items', array('ptype_id'=>2)), 'first_code'=>'hsub', 'second_code'=>"submenu nav-hide"),
//     					array('name'=>'历史删除项目', 'sub_menus'=>array(), 'controller_name'=>'Items', 'action_name'=>'history', "params"=>"ptype_id=2", 'url'=>U('Items/history', array('ptype_id'=>2)), 'first_code'=>'hsub', 'second_code'=>"submenu nav-hide"),
//     			), 'controller_name'=>'', 'action_name'=>'', 'url'=>'javascript:void(0);', 'first_code'=>'hsub', 'second_code'=>"submenu nav-hide"),
//     			array('name'=>"产品图片进度", 'class_code'=>'list', 'sub_menus'=>array(
//     					//array('name'=>'新建项目', 'sub_menus'=>array(), 'controller_name'=>'Items', 'action_name'=>'add_info', "params"=>"ptype_id=3", 'url'=>U('Items/add_info', array('ptype_id'=>3)), 'first_code'=>'hsub', 'second_code'=>"submenu nav-hide"),
//     					array('name'=>'未完成项目','sub_menus'=>array(), 'controller_name'=>'Items', 'action_name'=>'index', "params"=>"ptype_id=3", 'url'=>U('Items/index', array('ptype_id'=>3)), 'first_code'=>'hsub', 'second_code'=>"submenu nav-hide"),
//     					array('name'=>'全部项目', 'sub_menus'=>array(), 'controller_name'=>'Items', 'action_name'=>'list_items', "params"=>"ptype_id=3", 'url'=>U('Items/list_items', array('ptype_id'=>3)), 'first_code'=>'hsub', 'second_code'=>"submenu nav-hide"),
//     					array('name'=>'历史删除项目', 'sub_menus'=>array(), 'controller_name'=>'Items', 'action_name'=>'history', "params"=>"ptype_id=3", 'url'=>U('Items/history', array('ptype_id'=>3)), 'first_code'=>'hsub', 'second_code'=>"submenu nav-hide"),
//     			), 'controller_name'=>'Item', 'action_name'=>'', 'url'=>'javascript:void(0);', 'first_code'=>'hsub', 'second_code'=>"submenu nav-hide"),
// //     			array('name'=>"年度产品开发", 'class_code'=>'list', 'sub_menus'=>array(
// //     					array('name'=>'2016', 'sub_menus'=>array(), 'controller_name'=>'Items', 'action_name'=>'index', 'url'=>'javascript:void(0);', 'first_code'=>'hsub', 'second_code'=>"submenu nav-hide"),
// //     			), 'controller_name'=>'', 'action_name'=>'', 'url'=>'javascript:void(0);', 'first_code'=>'hsub', 'second_code'=>"submenu nav-hide"),
//     			array('name'=>'部门管理', 'class_code'=>'desktop', 'sub_menus'=>array(
//     					array('name'=>'部门列表', 'controller_name'=>'Deport', 'action_name'=>'index', 'url'=>U('Deport/index'), 'first_code'=>'hsub', 'second_code'=>"submenu nav-hide"),
//     					array('name'=>'添加部门', 'controller_name'=>'Deport', 'action_name'=>'add_info', 'url'=>U('Deport/add_info'), 'first_code'=>'hsub', 'second_code'=>"submenu nav-hide"),
//     					array('name'=>'角色列表', 'controller_name'=>'Roles', 'action_name'=>'index', 'url'=>U('Roles/index'), 'first_code'=>'hsub', 'second_code'=>"submenu nav-hide"),
//     					array('name'=>'添加角色', 'controller_name'=>'Roles', 'action_name'=>'add_info', 'url'=>U('Roles/add_info'), 'first_code'=>'hsub', 'second_code'=>"submenu nav-hide"),
//     					array('name'=>'人员列表', 'controller_name'=>'AdminUser', 'action_name'=>'index', 'url'=>U('AdminUser/index'), 'first_code'=>'hsub', 'second_code'=>"submenu nav-hide"),
//     					array('name'=>'添加人员', 'controller_name'=>'AdminUser', 'action_name'=>'add_info', 'url'=>U('AdminUser/add_info'), 'first_code'=>'hsub', 'second_code'=>"submenu nav-hide"),
//     			), 'controller_name'=>'', 'action_name'=>'', 'url'=>'javascript:void(0);', 'first_code'=>'hsub', 'second_code'=>"submenu nav-hide"),
//     			array('name'=>'流程说明资料', "code"=>'lc', 'class_code'=>'picture-o', 'sub_menus'=>array(
//     					array('name'=>'产品开发', 'controller_name'=>'Ptypes', 'action_name'=>'detail', 'params'=>"id=1", 'url'=>U('Ptypes/detail', array('id'=>1)), 'first_code'=>'hsub', 'second_code'=>"submenu nav-hide"),
//     					array('name'=>'产品下单进度', 'controller_name'=>'Ptypes', 'action_name'=>'detail', 'params'=>"id=2", 'url'=>U('Ptypes/detail', array('id'=>2)), 'first_code'=>'hsub', 'second_code'=>"submenu nav-hide"),
//     					array('name'=>'产品图片进度', 'controller_name'=>'Ptypes', 'action_name'=>'detail', 'params'=>"id=3", 'url'=>U('Ptypes/detail', array('id'=>3)), 'first_code'=>'hsub', 'second_code'=>"submenu nav-hide"),
// //     					array('name'=>'年度产品开发', 'controller_name'=>'Ptypes', 'action_name'=>'detail', 'params'=>"id=4", 'url'=>U('Home/Ptypes/detail', array('id'=>4)), 'first_code'=>'hsub', 'second_code'=>"submenu nav-hide"),
//     			), 'controller_name'=>'Ptype', 'action_name'=>'index', 'url'=>'javascript:void(0);', 'first_code'=>'hsub', 'second_code'=>"submenu nav-hide"),
// //     			array('name'=>"基础配置", 'class_code'=>'pencil-square-o', 'sub_menus'=>array(
// //     			array('name'=>'项目分类管理', 'sub_menus'=>array(
// //     							array('name'=>'分类列表', 'controller_name'=>'Ptypes', 'action_name'=>'index', 'url'=>U('Ptypes/index'), 'first_code'=>'hsub', 'second_code'=>"submenu nav-hide"),
// //     							array('name'=>'添加分类', 'controller_name'=>'Ptypes', 'action_name'=>'add_info', 'url'=>U('Ptypes/add_info'), 'first_code'=>'hsub', 'second_code'=>"submenu nav-hide"),
// //     					), 'controller_name'=>'Ptypes', 'action_name'=>'index', 'url'=>'javascript:void(0);', 'first_code'=>'hsub', 'second_code'=>"submenu nav-hide")
// //     			), 'controller_name'=>'', 'action_name'=>'', 'url'=>'javascript:void(0);', 'first_code'=>'hsub', 'second_code'=>"submenu nav-hide"),
//     	);
//     	$ptypes = M('ptypes')->where("status=1 and is_del=0")->order("rank asc,id asc")->select();
//     	foreach($ptypes as $value){
//     		array_push($sub_menus, array('name'=>$value['name'], "controller_name"=>"Ptypes", 
//     									 "action_name"=>"detail", "params"=>'id='.$value['id'], 
//     									 "url"=>U('Home/Ptypes/detail', array('id'=>$value['id'])), 
//     									 'first_code'=>'hsub', 'second_code'=>"submenu nav-hide"));
//     	}
        if( $user_info['id']!=1 ){
                $role = M('roles')->where("id=%d", array($this->user_info['role_id']))->find();
                if( !$role ){
                	$this->set_notice(2, "参数错误");
                	$menus = M('menus')->where("id=1")->order("rank,id")->select();
                	return $menus;
                }
                $s = M('role_menus')->where("role_id=%d", array($role['id']))->select();
                $m_ids = array();
                foreach($s as $v){
                        array_push($m_ids, $v['menus_id']);
                }
                $where = "id in (".implode(',', $m_ids).") and is_show=1";
    	}else{
    		$where = "is_show=1";
    	}
        $menus = M('menus')->where($where." and ptype=0")->order("rank,id")->select();
//        echo "<pre>";
//        print_r($menus);

        foreach($menus as $i=>$value){
                $a = M('menus')->where($where." and parent_id=%d and ptype=1", array($value['id']))->order("rank,id")->select();
                foreach($a as $j=>$val){
                        $b = M('menus')->where($where." and parent_id=%d and ptype=2", array($val['id']))->order("rank,id")->select();
                        foreach($b as $k=>$v){
                                $c = M('menus')->where($where." and parent_id=%d and ptype=3", array($v['id']))->order("rank,id")->select();
                                foreach($c as $n=>$va){
                                        $c[$n]['sub_menus'] = M('menus')->where($where." and parent_id=%d and ptype=4", array($va['id']))->order("rank,id")->select();
                                }
                                $b[$k]['sub_menus'] = $c;
                        }
                        $a[$j]['sub_menus'] = $b;
                }
                if( $value['id']==6 ){
                    $malls = M('mall')->where("is_del=0")->select();
                    foreach($malls as $k=>$b){
                        array_push($a, array('name'=>$b['name'], 'controller_name'=>"ShopCount", "action_name"=>"index", "params"=>"mall_id=".$b['id'], "ptype"=>1, "url"=>"ShopCount/index?mall_id=".$b['id']));
                    }
                }
               
                $menus[$i]['sub_menus'] = $a;
        }
//        echo "<pre>";
//        print_r($menus);
    	$params = array();
    	unset($_GET['PHPSESSID']);
    	foreach( $_GET as $k=>$v ){
    		array_push($params, $k."=".$v);
    	}
    	$str_params = implode("&", $params);
    	
    	foreach($menus as $i=>$value){     //第一层
    		
    		if( count($value['sub_menus'])>0 ){
    			foreach( $value['sub_menus'] as $j=>$val ){    //第二层
    				if( count($val['sub_menus'])>0 ){
    					foreach($val['sub_menus'] as $t=>$va){      //第三层
    						if( count($va['sub_menus'])>0 ){
    							foreach($va['sub_menus'] as $x=>$v){
    								if( count($v['sub_menus'])>0 ){
    									foreach($v['sub_menus'] as $y=>$q){
    										if( $q['controller_name']==CONTROLLER_NAME && $q['action_name']==ACTION_NAME && ( empty($q['params']) || $q['params']==$str_params) ){
    											$menus[$i]['sub_menus'][$j]['sub_menus'][$t]['sub_menus'][$x]['sub_menus'][$y]['first_code'] = 'active';
    											$menus[$i]['sub_menus'][$j]['sub_menus'][$t]['sub_menus'][$x]['sub_menus'][$y]['second_code'] = 'submenu open';
    											$menus[$i]['sub_menus'][$j]['sub_menus'][$t]['sub_menus'][$x]['first_code'] = 'active';
    											$menus[$i]['sub_menus'][$j]['sub_menus'][$t]['sub_menus'][$x]['second_code'] = 'submenu open';
    											$menus[$i]['sub_menus'][$j]['sub_menus'][$t]['first_code'] = 'active';
    											$menus[$i]['sub_menus'][$j]['sub_menus'][$t]['second_code'] = 'submenu open';
    											$menus[$i]['sub_menus'][$j]['first_code'] = "active";
    											$menus[$i]['sub_menus'][$j]['second_code'] = "submenu open";
    											$menus[$i]['first_code'] = 'active';
    											$menus[$i]['second_code'] = 'submenu open';
    										}
    									}
    								}else if( CONTROLLER_NAME==$v['controller_name'] && ACTION_NAME==$v['action_name'] && ( empty($v['params']) || $v['params']==$str_params) ){
	    								$menus[$i]['sub_menus'][$j]['sub_menus'][$t]['sub_menus'][$x]['first_code'] = 'active';
		    							$menus[$i]['sub_menus'][$j]['sub_menus'][$t]['sub_menus'][$x]['second_code'] = 'submenu open';
		    							$menus[$i]['sub_menus'][$j]['sub_menus'][$t]['first_code'] = 'active';
		    							$menus[$i]['sub_menus'][$j]['sub_menus'][$t]['second_code'] = 'submenu open';
		    							$menus[$i]['sub_menus'][$j]['first_code'] = "active";
		    							$menus[$i]['sub_menus'][$j]['second_code'] = "submenu open";
		    							$menus[$i]['first_code'] = 'active';
		    							$menus[$i]['second_code'] = 'submenu open';
	    							}
    							}
    						}else if( CONTROLLER_NAME==$va['controller_name'] && ACTION_NAME==$va['action_name'] && ( empty($va['params']) || $va['params']==$str_params) ){
	    							$menus[$i]['sub_menus'][$j]['sub_menus'][$t]['first_code'] = 'active';
	    							$menus[$i]['sub_menus'][$j]['sub_menus'][$t]['second_code'] = 'submenu open';
	    							$menus[$i]['sub_menus'][$j]['first_code'] = 'active';
	    							$menus[$i]['sub_menus'][$j]['second_code'] = 'submenu open';
	    							$menus[$i]['first_code'] = 'active';
	    							$menus[$i]['second_code'] = 'submenu open';
	    					}
    					}
    				}else if( CONTROLLER_NAME==$val['controller_name'] && ACTION_NAME==$val['action_name'] && ( empty($val['params']) || $val['params']==$str_params) ){
	    					$menus[$i]['sub_menus'][$j]['first_code'] = 'active';
	    					$menus[$i]['sub_menus'][$j]['second_code'] = 'submenu open';
	    					$menus[$i]['first_code'] = 'active';
	    					$menus[$i]['second_code'] = 'submenu open';
    				}
    			}
    		}else if( CONTROLLER_NAME==$value['controller_name'] && ACTION_NAME==$value['action_name'] && (empty($value['params']) || $value['params']==$str_params) ){
    			$menus[$i]['first_code'] = 'active';
    			$menus[$i]['second_code'] = 'submenu open';
    		}
    	}
//        echo "<pre>";
//        print_r($menus);
    	$this->assign('menus', $menus);
    }
	
    // 过滤代码
    public function str_filter($str) {
    
    	// 过滤 js
    	$js_string = array("/<script(.*)<\/script>/isU");
    	$str = preg_replace($js_string, '', $str);
    
    	// 过滤 iframe
    	$frame_string = array("/<frame(.*)>/isU", "/<\/fram(.*)>/isU", "/<iframe(.*)>/isU", "/<\/ifram(.*)>/isU",);
    	$str = preg_replace($frame_string, '', $str);
    
    	// 过滤 css
    	$style_string = array("/<style(.*)<\/style>/isU", "/<link(.*)>/isU", "/<\/link>/isU");
    	$str = preg_replace($style_string, '', $str);
    
    	// 过滤字符串
    	if (is_array($str)) {
    		foreach ($str as $k=>$v) {
    			$str[$k] = htmlspecialchars(strip_tags($v));
    		}
    	} else {
    		$str = htmlspecialchars(strip_tags($str));
    	}
    	// 过滤关键词，主要为sql方面
    	$arr = array('\\', ' IF(', '20%and20%', ' and ', ' AND ', '20%or20%', ' or ', ' OR ', '20%execute20%', ' execute ', '20%update20%', ' update ', '20%master20%', ' master ', '20%truncate20%', ' truncate ', '20%char20%', ' char ', 'CHAR(', '20%declare20%', ' declare ', '20%select20%', ' select ', 'SELECT', '20%create20%', ' create ', '20%delete20%', ' delete ', '20%insert20%', ' insert ', 'sleep', ' sleep ', 'table', ' table ', 'substring', ' substring ', '20%infmation_schema20%', ' infmation_schema ', '20%concat20%', ' concat ', 'CONCAT', '20%limit20%', ' limit ', 'UPDATEXML', 'EXTRACTVALUE', 'CONVERT(', ' WAITFOR DELAY ', '*', '!');
    	$str = str_replace($arr, '', $str);
    	$str = str_replace("'", "''", $str);
    
    	// 过滤回车换行，防止Header Sql注入
    	$str = str_replace(array('%0d', '%0a', '%0D', '%0A', '\n', '\r'), '', $str);
    
    	return $str;
    }

}