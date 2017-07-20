<?php
namespace Home\Controller;
use Common\Common\Controller\AdminBaseController;
class ProductPicController extends AdminBaseController {
    
	public $locations = array();
	public $ProductPic, $ptype_id;
	
	function __construct(){
		parent::__construct();
		$this->locations = array(
				array('is_checked'=>false, 'name'=>'产品管理', 'url'=>U('ProductPic/index'))
		);
		$this->ptype_id = 3;
		$this->ProductPic = D('ProductPic');
		$ptype = M('ptypes')->where("id=%d", array($this->ptype_id))->find();
		$ptype_statuses = D('Ptypes')->get_ptype_statuses($this->ptype_id);
		$this->assign('ptype_statuses', $ptype_statuses);
		$this->assign('s_status', D('Ptypes')->get_ptype_options($this->ptype_id));
		$this->assign('loc_name_1', $ptype['name']);
		$this->assign('locations', $this->locations);
	}
	
	public function history(){
		$this->assign("loc_name_2", "历史删除项目");
		$search_info['is_del'] = 1;
		$search_info['status'] = isset($_POST['status'])?intval($_POST['status']):0;
		$search_info['num'] = isset($_POST['num'])?intval($_POST['num']):intval($_GET['num']);
		$this->assign('search_info', $search_info);
		$res = $this->ProductPic->search_info($search_info);
		$this->assign('ProductPic', $this->ProductPic);
		$this->assign('product_pics', $res['product_pics']);
		$this->assign('show_page', $res['show_page']);
                $total_count = M('product_pic')->where("is_del=1")->select();
                $this->assign('total_count',count($total_count));
		$this->display("ProductPic/index");
	}
	
	public function list_items(){
		$this->assign("loc_name_2", "全部项目");
		$search_info['is_finish'] = 3;
		$search_info['status'] = isset($_POST['status'])?intval($_POST['status']):0;
		$search_info['num'] = isset($_POST['num'])?intval($_POST['num']):intval($_GET['num']);
                $search_info['code'] = isset($_POST['code'])?$_POST['code']:'';
                $search_info['number'] = isset($_POST['number'])?$_POST['number']:'';
                $search_info['name'] = isset($_POST['name'])?$_POST['name']:'';
                $search_info['pic'] = isset($_POST['pic'])?intval($_POST['pic']):'';
                $search_info['show'] = isset($_POST['show'])?intval($_POST['show']):'0';
		$this->assign('search_info', $search_info);
		$res = $this->ProductPic->search_info($search_info);
		$this->assign('ProductPic', $this->ProductPic);
		$this->assign('product_pics', $res['product_pics']);
		$this->assign('show_page', $res['show_page']);
                $total_count = M('product_pic')->select();
                $this->assign('total_count',count($total_count));
                $this->assign('is_more_search', 1);
                $this->assign('is_pic', 1);
		$this->display("ProductPic/index");
	}
	
	public function index(){
		$this->assign("loc_name_2", "未完成列表");
		$search_info['status'] = isset($_POST['status'])&&intval($_POST['status'])>0?intval($_POST['status']):(isset($_POST['status'])&&intval($_GET['status'])?intval($_GET['status']):0);
		$search_info['num'] = isset($_POST['num'])?intval($_POST['num']):intval($_GET['num']);
		if( empty($search_info['status']) ){
			$search_info['is_finish'] = 2;
		}
                $search_info['code'] = isset($_POST['code'])?$_POST['code']:'';
                $search_info['number'] = isset($_POST['number'])?$_POST['number']:'';
                $search_info['name'] = isset($_POST['name'])?$_POST['name']:'';
                $search_info['pic'] = isset($_POST['pic'])?intval($_POST['pic']):'';
                $search_info['show'] = isset($_POST['show'])?intval($search_info['show']):'0';
		$res = $this->ProductPic->search_info($search_info);
                $this->assign('search_info', $search_info);
		$this->assign('ProductPic', $this->ProductPic);
		$this->assign('product_pics', $res['product_pics']);
		$this->assign('show_page', $res['show_page']);
                $this->assign('number_per_page',$search_info['num']);
                $this->assign('page_number',$res['now_page']);
                $total_count = M('product_pic')->where("is_over=0")->select();
                $this->assign('total_count',count($total_count));
                $this->assign('is_more_search', 1);
                $this->assign('is_pic', 1);
    	        $this->display("ProductPic/index");
    }
    
    public function del(){
        
    	$f = M('product_pic')->where("id=%d", array($_GET['id']))->setField(array('is_del'=>1));
    	if( $f!==false ){
    		$this->set_notice(1, "删除成功");
    	}else{
    		$this->set_notice(2, "删除出错，请重试");
    	}
    	$this->redirect("ProductPic/index");
    }
    
    public function upload_file(){
    	include_once SITE_PATH.'/Home/Model/FileUpload.class.php';
    	$FileUpload = new \FileUpload();
        M()->startTrans();
    	if( isset($_FILES['file']) && !empty($_FILES['file']['name']) ){
    		$path = $FileUpload->save_file($_FILES['file'], "/uploadfiles/product_pics/".date('Y-m-d')."/");
    	}else{
    		$path = '';
    	}
    	$product_pic_status = M('product_pic_status')->where("id=%d", array($_POST['id']))->find();
    	$id = M('product_pic_status_attach')->add(array('product_pic_status_id'=>$product_pic_status['id'], 
    				'url'=>$path, 'content'=>isset($_POST['content'])?$_POST['content']:'', 
    			    'create_time'=>time(), 'admin_user_id'=>$_SESSION['admin_user_id']));
       M()->commit();
        
        
    	$this->redirect("ProductPic/index");
    }
    
    public function update_status(){
        
        //判断是否有附件或说明上传
//        $file_id = M('product_pic_status')->where("product_pic_id=%d",array($_GET['id']))->field("id")->find();
//        echo M()->getlastsql();
//        $file = M('product_pic_status_attach')->where('product_pic_status_id=%d',array($file_id['id']))->find();
//        if($file['id']){ 
            if( $_GET['t']=='checked' ){
            		M()->startTrans();
                	$f = M('product_pic_status')->where("product_pic_id=%d and ptype_status_id=%d", array($_GET['id'], $_GET['sid']))
                	     ->setField(array('status'=>1, 'checked_user_id'=>$this->admin_user_id, 'checked_time'=>time()));
                    $ptype_s = M('ptype_status')->where('id=%d', array($_GET['sid']))->find();
                	$res = M('ptype_status')->where("ptype_id=%d and rank>=%d and id!=%d", array($this->ptype_id, $ptype_s['rank'], $_GET['sid']))->order("rank asc, id")->find();
                	if( $res ){
                		$f1 = M('product_pic_status')->add(array('product_pic_id'=>$_GET['id'], 'ptype_status_id'=>$res['id'], 'create_time'=>time(), 'admin_user_id'=>$this->admin_user_id));
                	}else{
                		$f1 = M('product_pic')->where("id=%d", array($_GET['id']))->setField(array('is_over'=>1, 'finish_time'=>time()));
                	}
                	$judge = M('product_pic')->where("id=%d and is_over=1 and is_del=0",array($_GET['id']))->find();
                	if( $judge ){
                		$shops = M('shop')->where("is_del=0 and status=1")->select();
                		$product_pic = M('product_pic')->where("id=%d",array($_GET['id']))->find();
                		$save_data = array();
                		foreach($shops as $value){
                			array_push($save_data, array('product_id'=>$product_pic['product_id'],'shop_id'=>$value['id'],'mall_id'=>$value['mall_id']));
                		}
                		$id = M('count_info')->addAll($save_data);
                		if( $id<=0 ){
                			M()->rollback();
                			$this->redirect("ProductPic/index");
                			exit;
                		}
                        $name = M('products')->where("id=%d",array($judge['product_id']))->find();
                        $subject = "产品图片上传完成";
                        $body = "产品";
                        $body .=$name['name'];
                        $body .="已完成所有产品图片上传";
                        $mails = M('admin_user')->where("is_mail=1 and is_del=0")->select();
//                      $address = $mail['email'];
                        $addresses = array();
                        foreach($mails as $v){
//                                  array_push($addresses, $v['email']);
                               $re = D('AdminUser')->send_mail($subject,$body,$v['email']);
                        }
                                
                	}
                	M()->commit();
         	}else if($_GET['t']=='unchecked'){
                	$ptype_s = M('ptype_status')->where('id=%d', array($_GET['sid']))->find();
                	$res = M('ptype_status')->where("ptype_id=%d and rank<%d", array($this->ptype_id, $ptype_s['rank']))->order("rank desc, id desc")->find();
                        if( $res ){
                            M()->startTrans();
                            $f1 = M('product_pic_status')->where("product_pic_id=%d and ptype_status_id=%d", array($_GET['id'],$_GET['sid']))->setField(array('status'=>2));
                        	$f2 = M('product_pic_status')->where("product_pic_id=%d and ptype_status_id=%d", array($_GET['id'], $_GET['sid']))->delete();
                            $pre_sid=$_GET['sid']-1;
                            $product = M('product_pic_status')->where("product_pic_id=$_GET[id]")->find();
                            $options['content'] = $_GET['content'];
                            $options['product_pic_status_id'] = $product['id'];
                            $res = D('ProductPicStatusLog')->create_info($options);
                            $f3 = M('product_pic_status')->where("product_pic_id=%d and ptype_status_id=%d", array($_GET['id'],$pre_sid))->setField(array('status'=>0));
                            if($f1&&$f2&&$f3&&$res['status']){
                                 M()->commit();
                            }else{
                                 M()->rollback();
                            }
                	}
                        if($res){
                            echo 'SUCCESS';
                        }
            }
            $this->redirect("ProductPic/index");
//        }
//        else{
//            $this->set_notice(1, "未上传附件或添加描述");
//       }
            
            
            
    }
    
    
    
    public function mail($Subject,$body,$address) {
    	import('PHPMailer');
    	import('PHPSmtp');
    	
//    	$Subject = $_GET['title'];
//    	$body = $_GET['content'];
//    	$address = $_GET['email'];
    	
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
        $mail->AddAddress($address);
    	$mail->IsHTML(true);

    	$re = $mail->Send();
    	if( $re ){
    		echo "yes";
    	}else{
    		echo "no";
    	}
    	exit;
    }
    
}