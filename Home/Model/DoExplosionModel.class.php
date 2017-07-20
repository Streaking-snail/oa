<?php
namespace Home\Model;

use Home\Model\BaseModel;

class DoExplosionModel extends BaseModel
{

    protected $tableName = 'do_explosions';

    //搜索
    public function search_info($options = array())
    {
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
                  $where .= " and c.name = '$options[admin_user]'";
             }
             if( !empty($options['deport']) ){
                  $where .= " and d.name = '$options[deport]'";
             }
        }
        if( !empty($options['time1']) || !empty($options['time2']) ){
            if( !empty($options['time1']) && empty($options['time2']) ){
                $where .=" and a.create_time >= $options[time1]";
            }else if( empty($options['time1']) && !empty($options['time2'])){
                $where .=" and a.create_time <= $options[time2]";
            }else{
                $where .=" and a.create_time between $options[time1] and $options[time2]";
            }
        }
        $count = $this->alias('a')
            ->join("left join ".C('DB_PREFIX')."admin_user c on a.admin_user_id=c.id")
            ->join("left join ".C('DB_PREFIX')."deport d on c.deport_id=d.id")
            ->where($where)
            ->count();
        $page = $this->page($count, $options['num']);
        $data = $this->alias('a')->field('a.*,b.content as status_content')
            ->join('LEFT JOIN '.C('DB_PREFIX').'do_explosion_status b on a.id = b.do_explosion_id')
            ->join("left join ".C('DB_PREFIX')."admin_user c on a.admin_user_id=c.id")
            ->join("left join ".C('DB_PREFIX')."deport d on c.deport_id=d.id")
            ->field("a.*")
            ->where($where)
            ->group('a.id')
            ->limit($page->firstRow . ',' . $page->listRows)
            ->select();
        return array('data' => $data, 'show_page' => $page->show(),'count'=>$count);
    }

    //添加
    public function create_info($options = array())
    {
        $options['create_time'] = time();
        //explosion关联item表中相关数据
        $options['item']['admin_user_id'] = $options['admin_user_id'];
        $options['item']['create_time'] = $options['create_time'];
        $options['activity_time'] = strtotime($options['activity_time']);
        $explosion_item = $options['item'];
        unset($options['item']);
        //验证目前直接返回true
        $res = $this->valid($options);
        if (!$res['status']) return $res;
        M()->startTrans();
        //添加到明细表中
        $explosion_id = M('do_explosions')->add($options);
        if (intval($explosion_id) > 0) {
            //插入到do_overdue_delivery_attaches表中的数据(附件表)
            //插入到do_overdue_delivery_items,根据product_id为标准,进行插入
            $item = [];
            if (!empty($explosion_item)) {
                foreach ($explosion_item['product_id'] as $k => $v) {
                    if (!empty($v)) {
                        $item[] = array(
                            'product_id' => intval($v),
                            'apply_price' => $explosion_item['apply_price'][$k],
                            'apply_num' => $explosion_item['apply_num'][$k],
                            'price' => $explosion_item['price'][$k],
                            'content' => $explosion_item['content'][$k],
                            'admin_user_id' => $explosion_item['admin_user_id'],
                            'create_time' => $explosion_item['create_time'],
                            'do_explosion_id'=>$explosion_id
                        );
                    }
                }
            }
            $item_id = 1;
            if (!empty($item)) {
                $item_id = M('do_explosion_items')->addAll($item);
            }
            if (intval($item_id) > 0) {
                M()->commit();
                return array('status' => true, 'msg' => '添加成功');
            } else {
                M()->rollback();
                return array('status' => false, 'msg' => '添加失败');
            }
        } else {
            M()->rollback();
            return array('status' => false, 'msg' => '添加失败');
        }
    }

    //修改
    public function update_info($options = array())
    {
        $options['create_time'] = time();
        //explosion关联item表中相关数据
        $options['item']['admin_user_id'] = $options['admin_user_id'];
        $options['item']['create_time'] = $options['create_time'];
        $explosion_item = $options['item'];
        $options['activity_time'] = strtotime($options['activity_time']);//转时间戳
        $id = intval($options['id']);
        unset($options['id']);
        unset($options['item']);
        //验证目前直接返回true
        $res = $this->valid($options);
        if (!$res['status']) return $res;
        M()->startTrans();
        //添加到明细表中
        $f = M('do_explosions')->where('id=%d',array($id))->setField($options);
        if ($f!==false) {
            //插入到do_overdue_delivery_attaches表中的数据(附件表)
            //插入到do_overdue_delivery_items,根据product_id为标准,进行插入
            //新删老数据再重新插入
            $delete = M('do_explosion_items')->where('do_explosion_id=%d',array($id))->delete();
            if($delete===false){
                M()->rollback();
                return array('status' => false, 'msg' => '修改失败');
            }else{
                $item = [];
                if (!empty($explosion_item)) {
                    foreach ($explosion_item['product_id'] as $k => $v) {
                        if (!empty($v)) {
                            $item[] = array(
                                'product_id' => intval($v),
                                'apply_price' => $explosion_item['apply_price'][$k],
                                'apply_num' => $explosion_item['apply_num'][$k],
                                'price' => $explosion_item['price'][$k],
                                'content' => $explosion_item['content'][$k],
                                'admin_user_id' => $explosion_item['admin_user_id'],
                                'create_time' => $explosion_item['create_time'],
                                'do_explosion_id'=>$id
                            );
                        }
                    }
                }
                $item_id = 1;
                if (!empty($item)) {
                    $item_id = M('do_explosion_items')->addAll($item);
                }
                if (intval($item_id) > 0) {
                    M()->commit();
                    return array('status' => true, 'msg' => '修改成功');
                } else {
                    M()->rollback();
                    return array('status' => false, 'msg' => '修改失败');
                }
            }
        } else {
            M()->rollback();
            return array('status' => false, 'msg' => '修改失败');
        }
    }

    public function valid($options = array(), $status = 0)
    {
        return array('status' => true, 'msg' => 'ok');
    }

    //状态审核表 获取最晚的那个状态
    public function get_status_name($id)
    {
        $status_name = '未审核';
        if(intval($id)>0){
            $data = M('do_explosion_status')->where('do_explosion_id = %d',array(intval($id)))->order('create_time desc')->find();
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