<?php
namespace Home\Model;
use Home\Model\BaseModel;
class ProductOrderModel extends BaseModel{
	
	protected $tableName = 'product_order';
	//搜索
	public function search_info( $options=array() ){
		$where = "b.status=1";
		if( $options['is_del']==1 ){
			$where .= " and a.is_del=1";
		}else{
			$where .= " and a.is_del=0";
		}
		if($options['is_finish']==2){   //未完成
			$where .= " and a.dh_num<=0";
		}
//		if( !empty($options['key']) ){
//			$where .= " and b.name like '%".$this->str_filter($options['key'])."%'";
//		}
//		if( !empty($options['number']) ){
//			$where .= " and (b.number like '%".$this->str_filter($options['number'])."%' or b.code like '%".$this->str_filter($options['number'])."%')";
//		}
                if( !empty($options['code']) ){
                        $where .=" and b.code like '%".$this->str_filter($options['code'])."%'";  
                }
                if( !empty($options['number']) ){
                        $where .=" and b.number like '%".$this->str_filter($options['number'])."%'";  
                }
                if( !empty($options['name']) ){
                        $where .=" and b.name like '%".$this->str_filter($options['name'])."%'";  
                }
                if( !empty($options['time1']) && !empty($options['time2']) ){
                        if( $options['time'] == 'order_time' ){
                            $where .=" and a.order_time between $options[time1] and $options[time2]";
                        }else if( $options['time'] == 'dh_time'){
                            $where .=" and a.dh_time between $options[time1] and $options[time2]";
                        }
                }
                if( !empty($options['sort']) ){
                    if( $options['sort'] == 'deliver_time_up' ){
                        $sort = "a.deliver_time asc";
                    }else if( $options['sort'] == 'deliver_time_down' ){
                        $sort = "a.deliver_time desc";
                    }else if( $options['sort'] == 'dh_time_up' ){
                        $sort = "a.dh_time asc";
                    }else if( $options['sort'] == 'dh_time_down' ){
                        $sort = "a.dh_time desc";
                    }else{
                        $sort = "a.rank,a.id";
                    }
                }
		$num = isset($options['num'])?intval($options['num']):10;
		$count = $this->alias('a')->join("left join ".C('DB_PREFIX')."products b on b.id=a.product_id")->where($where)->count();
		$npage = $this->page($count, $num);
		$product_orders = $this->alias('a')->join("left join ".C('DB_PREFIX')."products b on b.id=a.product_id")->field('a.*,b.number,b.code,b.name')
					->where($where)->order($sort)->limit($npage->firstRow . ',' . $npage->listRows)->select();
		return array('product_orders'=>$product_orders,'show_page'=>$npage->show(),'now_page'=>$npage->firstRow);
	}
	
	//修改
	public function update_info( $options=array() ){
//                $res = $this->valid($options);
// 		if(!$res['status']) return $res;
		$id = $options['id'];
		unset($options['id']);
		$options['update_time'] = time();
                $options['order_time'] = !empty($options['order_time'])?strtotime($options['order_time']):0;
                $options['deliver_time'] = !empty($options['deliver_time'])?strtotime($options['deliver_time']):0;
                $options['dh_time'] = !empty($options['dh_time'])?strtotime($options['dh_time']):0;
		M()->startTrans();
		$f = M('product_order')->where("id=%d", array($id))->setField($options);
		$product_order = M('product_order')->where("id=%d", array($id))->find();
		if( intval($options['dh_num']) && intval($options['order_time']) && intval($options['jd_num']) && intval($options['tm_num']) && intval($options['tb_num']) && intval($options['ka_num']) && intval($options['sc_num']) && intval($options['deliver_time']) && intval($options['dh_time'])){
			 $ptype_status = M('ptype_status')->where("ptype_id=3")->order("rank asc, id")->find();
			 $product_pic =  M('product_pic')->where("product_id=%d", array($product_order['product_id']))->find();
             M('product_order_deliver')->add(array("product_order_id"=>$id, 'num'=>$product_order['dh_num'], 
             								"admin_user_id"=>$_SESSION['admin_user_id'], "create_time"=>time(),
             								"deliver_time"=>$product_order['dh_time']));    
                            $name = M('products')->where('id=%d',array($product_order['product_id']))->find();
                            $subject = "产品到货";
                            $body = "产品";
                            $body .= $name['name'];
                            $body .= "已到货";
                            $mails = M('admin_user')->where("is_mail=1 and is_del=0")->select();
//                                $address = $mail['email'];
                            $addresses = array();
                            foreach($mails as $v){
//                              array_push($addresses, $v['email']);
                                $re = D('AdminUser')->send_mail($subject,$body,$v['email']);
                            }
                         
			 if( !$product_pic ){
				 $pic_id = M('product_pic')->add(array('product_id'=>$product_order['product_id'], 'status'=>$ptype_status['id'], 'admin_user_id'=>$_SESSION['admin_user_id'], 'create_time'=>time()));
                                 $judge = M('product_pic_status')->where(array('product_pic_id'=>$pic_id, 'is_del=0'))->find();
                                if(!$judge){
                                $status_id = M('product_pic_status')->add(array(
                                     'product_pic_id'=>$pic_id, 'ptype_status_id'=>$ptype_status['id'],
                                    'create_time'=>time(),'admin_user_id'=>$product_order['admin_user_id']));
                                }
                        }else{
			 	$pic_id = 1;
			 	$status_id = 1;
                        }
		}else{
			$pic_id = 1;
			$status_id = 1;
		}
		if( $f!==false && $pic_id>0 && $status_id>0 ){
			M()->commit();
			return array('status'=>true, 'msg'=>'修改信息成功');
//                        $product_info = M('product_order')->where("id=%d and dh_num>0",array($id))->find();
//                        if($product_info){
//                            $name = M('products')->where('id=%d',array($product_info['product_id']))->find();
//                            $sbuject = "产品到货";
//                            $body = "产品";
//                            $body .= $name['name'];
//                            $body .= "已到货";
//                            $mails = M('admin_user')->where("is_mail=1 and is_del=0")->select();
//                            print_r($mails);
//                            exit;
////                                $address = $mail['email'];
//                            $addresses = array();
//                            foreach($mails as $v){
////                              array_push($addresses, $v['email']);
//                                $re = D('AdminUser')->send_mail($subject,$body,$v['email']);
//                            }
//                        }
                        }else{
			M()->rollback();
			return array('status'=>false,'msg'=>'修改失败');
		}
	}
	
	public function valid( $options=array() ){
		if( intval($options['order'])<=0 ){
			return array('status'=>false, 'msg'=>"请填写下单时间");
		}
		if( intval($options['sub_category_id'])<=0 ){
			return array('status'=>false, 'msg'=>"请填写下单数量");
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
	

	public function get_show_time($time){
		$t = time()-$time;
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
		return $str;
	}
	
	public function get_show_status($id){
		$product_order = M('product_order')->where("id=%d", array($id))->find();
		$t = time()-$time;
		$d = intval($t/3600/24);
		if( $product_order['sc_num']<=0 ){
			return '<span class="label label-sm label-warning">未添加信息</span>';
		}
		if( $product_order['deliver_time']<=0 ){
			if( $d>7 ){
				return '<span class="label label-sm label-warning">未大货前样</span>';
			}else{
				return '<span class="label label-sm label-info arrowed arrowed-righ">未大货前样</span>';
			}
		}
		if( $product_order['dh_time']<=0 ){
			if( $d>7 ){
				return '<span class="label label-sm label-warning">未到货</span>';
			}else{
				return '<span class="label label-sm label-info arrowed arrowed-righ">未到货</span>';
			}
		}
		if( $product_order['dh_num']<=0 ){
			return '<span class="label label-sm label-info arrowed arrowed-righ">未填到货数</span>';
		}
		if( $product_order['dh_num']>=0 ){
			if($product_order['dh_num']>=($product_order['jd_num']+$product_order['tm_num']+$product_order['tb_num']+$product_order['ka_num']+$product_order['sc_num'])){
				return '<span class="label label-sm label-success">完成</span>';
			}else{
				return '<span class="label label-sm label-inverse arrowed-in">到货数不足</span>';
			}
		}
	}
	
	public function get_deliver_num($product_order_id){
		$product_order = M('product_order')->where("id=%d", array($product_order_id))->find();
		$num = M("product_order_deliver")->where("product_order_id=%d", array($product_order['id']))->sum("num");
		return $num;
	}
        
	public function get_deliver_time($product_order_id){
		$product_order_deliver = M("product_order_deliver")->where("product_order_id=%d", array($product_order_id))->order("deliver_time desc")->find();
		return $product_order_deliver['deliver_time'];
	}
	
	public function add_deliver_num($options=array()){
		if(intval($options['num'])<=0){
			return array('status'=>false, "notice"=>"请输入到货数量");
		}
		if( empty($options['deliver_time']) ){
			return array("status"=>false, "notice"=>"请填写收货时间");
		}
		$options['deliver_time'] = strtotime($options['deliver_time']);
		$options['admin_user_id'] = $_SESSION['admin_user_id'];
		$options['create_time'] = time();
		$id = M('product_order_deliver')->add($options);
		if( $id>0 ){
			return array("status"=>true, "notice"=>"ok");
		}else{
			return array("status"=>false, "notice"=>"出错");
		}
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

