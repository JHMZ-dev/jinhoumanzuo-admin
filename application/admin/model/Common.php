<?php
namespace app\admin\model;

use think\Model;

/**
 * 公共方法
 * Class Common
 * @package app\admin\model
 */
class Common extends Model
{
    /**
     * 获取藏品_类型配置
     * @return array
     */
    static public function get_cp_type()
    {
        return [
            '1' => '个人',
            '2' => '工作室',
            '3' => '公司',
        ];
    }

    /**
     * 获取提现结果
     * @return array
     */
    static public function cash_res()
    {
        return [
            '1' => '处理中',
            '2' => '成功',
            '3' => '失败',
        ];
    }

    /**
     * 订单选择的付款方式
     * @return array
     */
    static public function order_type()
    {
        return [
            '1' => '默认值',
            '2' => '充值标点',
            '3' => '开通会员',
            '4' => '续费会员',
            '5' => '购买商品',
        ];
    }

    /**
     * 订单状态
     * @return array
     */
    static public function order_status()
    {
        return [
            '0' => '未支付',
            '1' => '已支付'
        ];
    }

    /**
     * 支付类别
     * @return array
     */
    static public function order_bie()
    {
        return [
            '1' => '支付宝',
            '2' => '微信',
            '3' => '银行卡'
        ];
    }
}