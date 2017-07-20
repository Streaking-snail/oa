<?php
namespace Home\Model;
use Home\Model\BaseModel;
class AdminUserModel extends BaseModel{
	
	protected $tableName = 'admin_user';
	public $secret = 'guangbo';
	
	//获取登录 
	public function login( $psd, $username ){
		$admin_user = $this->where("username='%s'", array($username))->find();
		if( $admin_user ){
			$password = md5($psd.$this->secret);
			if( $admin_user['password']==$password ){
				if( $admin_user['is_lock']==0 ){
					$_SESSION['admin_user_id'] = $admin_user['id'];
					return array('status'=>true, 'msg'=>'ok');
				}else{
					return array('status'=>false, 'msg'=>"用户被锁定或删除");
				}
			}else{
				return array('status'=>false, 'msg'=>'密码错误');
			}
		}else{
			return array('status'=>false, 'msg'=>'用户名错误');
		}
	}
	
	//搜索
	public function search_info( $options=array() ){
		if( intval($options['status'])==3 ){
			$where = "is_del=1";
		}else{
			$where = "is_del=0";
		}
		if( !empty($options['key']) ){
			$where .= " and (name like '%".$this->str_filter($options['key'])."%' or username like '%".$this->str_filter($options['key'])."%')";
		}
		if( !empty($options['start_time']) ){
			$where .= " and create_time<=".strtotime($this->str_filter($options['start_time']));
		}
		if( !empty($options['end_time']) ){
			$where .= " and create_time<=".strtotime($this->str_filter($options['end_time']));
		}
		if( in_array(intval($options['status']), array(1,2)) ){
			$where .= " and status=".intval($options['status']);
		}
		if( isset($options['deport_id']) && intval($options['deport_id'])>0 ){
			$where .= " and deport_id=".intval($options['deport_id']);
		}
		$num = isset($options['num'])?intval($options['num']):10;
		$count = $this->where($where)->count();
		$npage = $this->page($count, $num);
		$admin_users = $this->where($where)->limit($npage->firstRow . ',' . $npage->listRows)->select();
		return array('admin_users'=>$admin_users,'show_page'=>$npage->show(), "now_page"=>$npage->firstRow);
	}
	
	//修改
	public function create_info( $options=array() ){
		$res = $this->valid($options);
		if(!$res['status']) return $res;
		if( empty($options['password']) || empty($options['confirm_password']) ){ return array('status'=>false, 'msg'=>'请输入密码');}
		if( $options['password']!=$options['confirm_password'] ){
			return array('status'=>false, 'msg'=>"密码与确认密码不一致");
		}
		$r = M('admin_user')->where("username='%s'", array($options['username']))->find();
		if($r){return array('status'=>false, "msg"=>"用户名已存在");}
		$options['create_time'] = time();
		$options['password'] = md5($options['password'].$this->secret);
		$id = M('admin_user')->add($options);
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
		if( empty($options['passowrd']) ){
			unset($options['passowrd']);
			unset($options['confirm_passowrd']);
		}else{
			if($options['password']!=$options['confirm_pasword']){ return array('status'=>false, 'msg'=>"密码与确认密码不一至"); }
			$opitions['password'] = md5($options['password'].$this->secret);
		}
		$id = $options['id'];
		unset($options['id']);
		$f = M('admin_user')->where("id=%d", array($id))->setField($options);
		if( $f!==false ){
			return array('status'=>true, 'msg'=>'修改信息成功');
		}else{
			return array('status'=>false,'msg'=>'修改失败');
		}
	}
	
	//获取部门
	public function deport_name($deport_id){
		$deport = M('deport')->where("id=%d", array($deport_id))->find();
		return $deport['name'];
	}
	
	//获取角色
	public function role_name( $role_id ){
		$role = M('roles')->where("id=%d", array($role_id))->find();
		return $role['name'];
	}
	
	public function valid( $options=array() ){
		if( empty($options['username']) ){
			return array('status'=>false, 'msg'=>"请输入用户名");
		}
		if( isset($options['id']) && intval($options['id'])>0 ){
			$n = M("admin_user")->where("username='%s' and id!=%d", array($options['username'],$options['id']))->count();
			if( $n>0 ){
				return array("status"=>false, "msg"=>"用户名有重复");
			}
		}else{
			$n = M("admin_user")->where("username='%s'", array($options['username']))->count();
			if( $n>0 ){
				return array("status"=>false, "msg"=>"用户名有重复");
			}
		}
		//if( empty($options['name']) ){
		//	return array('status'=>false, 'msg'=>"请输入姓名");
		//}
		//if( empty($options['mobile']) ){
		//	return array('status'=>false, 'msg'=>"请输入手机号");
		//}
		return array('status'=>true, 'msg'=>'ok');
	}
	
	//修改密码
	public function edit_password($password, $confirm_password, $admin_user_id){
		if( empty($password) ){
			return array('status'=>false, 'msg'=>'请输入密码');
		}
		if( empty($confirm_password) ){
			return array('status'=>false, 'msg'=>'请输入确认密码');
		}
		if( $password!=$confirm_password ){
			return array('status'=>false, 'msg'=>'密码与确认密码不一至');
		}
		$f = $this->where("id=%d",array($admin_user_id))->setField(array('password'=>md5($password.$this->secret)));
		if( $f!==false ){
			return array('status'=>true, 'msg'=>'修改密码成功，请重新登录');
		}else{
			return array('status'=>false, 'msg'=>'修改密码失败');
		}
	}
	
	public function get_name($admin_user_id){
		$admin_user = M('admin_user')->where("id=%d", array($admin_user_id))->find();
		return !empty($admin_user['name'])?$admin_user['name']:$admin_user['username'];
	}
	public function deport_by_user($admin_user_id){
		$deport_name =  M('admin_user')->field('b.`name`')->alias('a')->join('JOIN '.C('DB_PREFIX').'deport b on a.deport_id=b.id')
			->where("a.id=%d", array($admin_user_id))->find();
		return $deport_name['name'];
	}
	
        public function send_mail($Subject,$body, $addresses) {

            import('PHPMailer');
            import('PHPSmtp');

            $mail = new \PHPMailer();
            $mail->CharSet = "utf-8";
            $mail->IsSMTP();
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = "ssl";
            $mail->Host = C("SP_MAIL_SMTP");
            $mail->Port = C("SP_MAIL_PORT");

            $mail->Username = C('SP_MAIL_ADDRESS');
            $mail->Password = C("SP_MAIL_PASSWORD");
            $mail->From = C('SP_MAIL_ADDRESS'); //, C("SP_MAIL_COMPANY"));
            $mail->FromName = C("SP_MAIL_COMPANY");
            $mail->FromEmail = C('SP_MAIL_ADDRESS');
            $mail->AddReplyTo(C('SP_MAIL_ADDRESS'), C("SP_MAIL_COMPANY"));//回复地址
            $mail->Subject = $Subject;
            $mail->Body = $body;
//            $mail->SingleTo = true;
//            $mail->SingleToArray = $addresses;
            $mail->AddAddress( $addresses );
            $mail->IsHTML(true);
            $re = $mail->Send();
            if( $re ){
                    return true;
            }else{
                    return false;
            }
        }
        
        //获取部门名称
        public function get_deport_name($admin_user_id){
        	$role = M('roles')->alias("a")->join("left join ".C('DB_PREFIX')."admin_user b on b.role_id=a.id ")
        	->field("a.*")->where("a.admin_user_id=%d", array($admin_user_id))->find();
        	$deport = M('deport')->where("id=%d", array($role['deport_id']))->find();
        	return $deport['name'];
//                $role = M('deport')->alias("a")->join("left join ".C('DB_PREFIX')."admin_user b a.id=b.deport_id")
//                ->field("a.name")->where("b.id = %d",array($admin_user_id) )->find();
//                return $role;
        }
        //获取用户名
        public function get_username($admin_user_id){
            $arr = M('Admin_user')->where('id = %d',array($admin_user_id))->field('name,username')->find();
            if($arr['name']){
                return $arr['name'];
            }else{
                return $arr['username'];
            }
        }
        //根据用户id获取部门
        public function get_name_deport($admin_user_id){
            $role = M('deport')->alias("a")->join("left join ".C('DB_PREFIX')."admin_user b on a.id=b.deport_id")
            ->field("a.name")->where("b.id = %d",array($admin_user_id) )->find();
            return $role['name'];
        }
}