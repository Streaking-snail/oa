<?php
namespace Home\Controller;
use Think\Controller;
class LoginController extends Controller {
	
    public function index(){
    	layout(false);
        $this->display('index');
    }
	public function login(){
       if( isset($_POST['password']) && isset($_POST['username']) ){
       	  $res = D('AdminUser')->login($_POST['password'], $_POST['username']);
       	  if( $res['status'] ){
       	  	 $_SESSION['notice_code'] = "login_index";
       	  	 $_SESSION['notice'] = '登录成功';
       	  	 $this->redirect('Index/index');
       	  	 exit;
       	  }else{
       	  	 $_SESSION['notice'] = $res['msg'];
       	  }
       }else{
       	  $_SESSION['notice'] = '用户名或密码为空';
       }
       $_SESSION['notice_code'] = 'login';
       $this->redirect("Login/index");
    }
    
    public function logout(){
    	unset($_SESSION['admin_user_id']);
    	$this->redirect("Home/Login/index");
    }
}