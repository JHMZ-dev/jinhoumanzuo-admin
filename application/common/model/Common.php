<?php

namespace app\common\model;

use think\Model;
use think\Db;
class Common extends Model
{
    /**
     * 读取系统配置
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function get_system()
    {
        $data = [];
        //系统配置转换前
        $res = Db::name('admin_set')->select();
        if(!empty($res))
        {
            //系统配置转换后
            foreach ($res as $k => $v)
            {
                $data[$v['set_cname']] = $v['set_cvalue'];
            }
            //分隔一下 上传后缀
            $data['extension']  = explode('|', $data['extension']);
        }
        return $data;
    }
    /**
     * 创建订单号
     */
    public static function createOrderSN()
    {
        return date('YmdHis') . rand(1000, 9999);
    }

    /**
     * 生成支付订单
     * @param $user_id
     * @param $to_id
     * @param $pay_type
     * @param $price
     * @param $order_type
     * @return bool|string
     */
    public static function create_order($user_id,$to_id,$pay_type,$price,$order_type)
    {
        //生成订单
        //生成订单号
        $orderSn = self::createOrderSN();
        $orderDatas = [
            'order_sn'          => $orderSn,         // 这里要保证订单的唯一性
            'user_id'           => $user_id,         //用户id
            'to_id'             => $to_id,           //为谁支付的id
            'payment_type'      => $pay_type,        //支付类型  1.alipay   2.wechat
            'need_money'        => $price,           //需要支付的金额
            'order_status'      => '0',              //订单状态 0-未支付；1-已支付
            'add_time'          => time(),           //订单生成时间
            'order_type'        => $order_type,              //开通类型 1发布红包动态 2充值标点 3开通会员 4续费会员
            'is_real'           => 0,              //1真实下单 0模拟下单
        ];
        //入库
        $res = Db::name('order')->insert($orderDatas);
        if($res)
        {
            return $orderSn;
        }else{
            return false;
        }
    }
}