<?php
namespace Home\Model;

use Home\Model\BaseModel;

class DoOverdueDeliveryModel extends BaseModel
{

    protected $tableName = 'do_overdue_deliveries';

    //搜索
    public function search_info($options = array())
    {
//        $where = '';
        $where = "a.is_del=0";
        //关键字待更新
//        if (!empty($options['key'])) {
//            $where .= " and name like '%" . $this->str_filter($options['key']) . "%'";
//        }
        $options['num'] = isset($options['num']) ? intval($options['num']) : 10;
        $user = $this->get_admin_user();
        if( $user['is_admin']==0 && $user['id']!=1 ){
        	$where .= " and a.admin_user_id=".$user['id'];
        }else{
	        if( !empty($options['admin_user']) ){
	                $where .= " and d.name = '$options[admin_user]'";
	        }
	        if( !empty($options['deport']) ){
	                $where .= " and e.name = '$options[deport]'";
	        }
        }
        if( !empty($options['time1']) || !empty($options['time2']) ){
            if( !empty($options['time1']) && empty($options['time2']) ){
                $where .=" and a.apply_time >= $options[time1]";
            }else if( empty($options['time1']) && !empty($options['time2'])){
                $where .=" and a.apply_time <= $options[time2]";
            }else{
                $where .=" and a.apply_time between $options[time1] and $options[time2]";
            }
        }
        $count = $this->alias('a')
            ->join("left join ".C('DB_PREFIX')."admin_user d on a.admin_user_id=d.id")
            ->join("left join ".C('DB_PREFIX')."deport e on d.deport_id=e.id")
            ->where($where)
            ->count();
        $page = $this->page($count, $options['num']);
        $do_overdue_list = $this->alias('a')->field('a.*,b.is_del,b.url_path,c.`status`,c.admin_user_id as check_user_id')
            ->join('LEFT JOIN ' . C('DB_PREFIX') . 'do_overdue_delivery_attaches b on a.id = b.do_overdue_delivery_id '
                . ' LEFT JOIN ' . C('DB_PREFIX') . 'do_overdue_delivery_status c on a.id = c.do_overdue_delivery_id'
                . ' LEFT JOIN ' . C('DB_PREFIX') . 'admin_user d on d.id = a.admin_user_id'
                . ' LEFT JOIN ' . C('DB_PREFIX') . 'deport e on e.id = d.deport_id')
            ->field("a.*")
            ->where($where)->order("c.status, c.create_time desc")
            ->group('a.id')
            ->limit($page->firstRow . ',' . $page->listRows)
            ->select();
        return array('do_overdue_list' => $do_overdue_list, 'show_page' => $page->show());
    }

    //添加
    public function create_info($options = array())
    {
        $options['create_time'] = time();
        $options['apply_time'] = strtotime($options['apply_time']);
        $res = $this->valid($options);
        if (!$res['status']) return $res;
        M()->startTrans();
        //添加到明细表中
        $overdue_id = M('do_overdue_deliveries')->add($options);
        if (intval($overdue_id) > 0) {
            //插入到do_overdue_delivery_attaches表中的数据 附件未完成
            M()->commit();
            return array('status' => true, 'msg' => '添加成功');
        } else {
            M()->rollback();
            return array('status' => false, 'msg' => '添加失败');
        }
    }

    //修改
    public function update_info($options = array())
    {
        $overdue = M('do_overdue_deliveries')->where("id=%d", array($options['id']))->find();
        $res = $this->valid($options);
        if (!$res['status']) return $res;
        $id = $options['id'];
        unset($options['id']);
        unset($options['admin_user_id']);
        M()->startTrans();
        $options['apply_time'] = strtotime($options['apply_time']);//转成时间戳
        $f = M('do_overdue_deliveries')->where("id=%d", array($id))->setField($options);
        if ($f !== false) {
            M()->commit();
            return array('status' => true, 'msg' => '修改信息成功');
        } else {
            M()->rollback();
            return array('status' => false, 'msg' => '修改失败');
        }
    }

    public function valid($options = array(), $status = 0)
    {
        //验证 TO DO
        return array('status' => true, 'msg' => 'ok');
        if ($status == 0) {
            if (empty($options['overdue_no'])) {
                return array('status' => false, 'msg' => "请填写单据号");
            }
            if (empty($options['user_name'])) {
                return array('status' => false, 'msg' => "请填写客户名称");
            }
            if (doubleval($options['credit_price']) <= 0) {
                return array('status' => false, 'msg' => "请填写授信金额");
            }
            if (doubleval($options['flow_price']) <= 0) {
                return array('status' => false, 'msg' => "请输入正确的超额金额");
            }
            if (intval($options['days']) <= 0) {
                return array('status' => false, 'msg' => "请输入正确的付款期限");
            }
        }
        return array('status' => true, 'msg' => 'ok');
    }
    //状态审核表 获取最晚的那个状态
    public function get_status_name($id)
    {
        $status_name = '未审核';
        if(intval($id)>0){
            $data = M('do_overdue_delivery_status')->where('do_overdue_delivery_id = %d',array(intval($id)))->order('create_time desc')->find();
            if($data['status']){
                switch (intval($data['status'])){
                    case 1 :
                        $status_name = '<span style="color: green">审核通过</span>';
                        break;
                    case 2 :
                        $status_name = '<span style="color:red;">审核不通过</span>';
                        break;
                }
            }
        }
        return $status_name;
    }
}