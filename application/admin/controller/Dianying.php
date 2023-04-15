<?php
namespace app\admin\controller;

use app\admin\controller\Common;

use app\common\model\VyangAdminPush;
use OSS\Core\OssException;
use think\Db;
use think\Request;
use think\Loader;


/**
 *  话费管理
 * Class Puman
 * @package app\admin\controller
 */
class Dianying extends Common
{
    /**
     * 初始加载
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    protected function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        //加载是否选中
        $this->assign('active','21');
    }

    //列表
    public function dianying_order_list(){

        // 查询数据 并且每页显示10条数据
        $cont    = $this->request->get('cont');
        $type       = $this->request->get('type');
        $status     = $this->request->get('status');
        $lei     = $this->request->get('lei');

        $map    = [];
        $page = '';

        if(!empty($cont))
        {
            $cont_type    = $this->request->get('cont_type');
            if($cont_type == 1)
            {
                $map['cinema_order_id']       = ['eq', $cont];
            }
            if($cont_type == 2)
            {
                $map['user_id']       = ['eq', $cont];
            }
            if($cont_type == 3)
            {
                $map['orderNumber2']       = ['eq', $cont];
            }
        }

        $list   = PageSeach('cinema_user_order', $map,[], 'cinema_order_id desc', '1000', false, Request::instance()->param());

        if(!empty($list))
        {
            $page = $list->render();
            $list = $list->all();
            foreach ($list as $k => $v)
            {
                if(!empty($v['buyTime']))
                {
                    $list[$k]['buyTime']        = replaceTime($v['buyTime']);
                }else{
                    $list[$k]['buyTime']        = '';
                }
                $city = Db::name('city')->where('city_id',$v['city_id'])->value('name');
                if(!empty($city)){
                    $list[$k]['city_id'] = $city;
                }else{
                    $list[$k]['city_id'] = '';
                }

            }
        }

        if(!empty($list))
        {
            $list = _xss($list);
        }

        // 把分页数据赋值给模板变量list
        $this->assign('order',$list);
        $this->assign('show',$page);
        // 渲染模板输出

        return $this->fetch();
    }


    /**导出
     * @return null
     * @throws \PHPExcel_Exception
     * @throws \PHPExcel_Reader_Exception
     * @throws \PHPExcel_Writer_Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function out_dianying_list(){
        $piostdata = $this->request->post('arr/a',0);
        $path = '/filexlsx/'.md5(time().rand(100000,999999)).'.xlsx';
        $name = '列表';
        $title = [
            '序号',
            '用户ID',
            '订单号',
            '系统订单号',
            '下单时间',
            '类型',
            '状态',
            '电影名称',
            '影院名称',
            '座位数',
            '售价',
            '通证',
        ];
        $url = 'http://'.$_SERVER['HTTP_HOST'].$path;
        $d = [];
        //查询
        $where['cinema_order_id'] = ['in',implode(',',$piostdata)];
        $order_data = Db::name('cinema_user_order')->where($where)->select();

        foreach ($order_data as $k => $v)
        {
            $d[$k]['序号'] = $v['cinema_order_id'];
            $d[$k]['用户ID'] = $v['user_id'];
            $d[$k]['订单号'] = $v['orderNumber2']?$v['orderNumber2']:'暂无';
            $d[$k]['系统订单号'] = $v['orderNumber']?$v['orderNumber']:'无';
            $d[$k]['下单时间'] = replaceTime($v['buyTime']);
            $leixin = '无';
            if($v['status'] == -1){$leixin = '报价中';}
            if($v['status'] == 0){$leixin = '默认/出票中';}
            if($v['status'] == 1){$leixin = '出票成功';}
            if($v['status'] == 2){$leixin = '出票失败';}
            if($v['status'] == 3){$leixin = '订单关闭';}
            $d[$k]['类型'] = $leixin;

            $zhuangtai = '无';
            if($v['order_status'] == 1){$zhuangtai = '已支付';}
            if($v['order_status'] == 0){$zhuangtai = '未支付';}
            $d[$k]['状态'] = $zhuangtai;
            $d[$k]['电影名称'] = $v['movieName']?$v['movieName']:'无';
            $d[$k]['影院名称'] = $v['cinemaName']?$v['cinemaName']:'无';
            $d[$k]['座位数'] = $v['ticketNum']?$v['ticketNum']:'无';
            $d[$k]['售价'] = $v['yuanjia']?$v['yuanjia']:'无';
            $d[$k]['通证'] = $v['yuanjia_tz']?$v['yuanjia_tz']:'无';
        }

        $data = $d;
        $odata = wps($name,$title,$data,ROOT_PATH.'/public'.$path);

        if($odata){
            //return jsonSuccess(200,"<a href='". $url ."'>点击立即下载</a>  ".$url,['url' =>$url ]);
            return jsonSuccess(200,"<a href='". $url ."'>点击立即下载</a>  ");
        }else{
            return jsonError(500,'当前人数太多，处理失败，请稍后再试','');
        }
    }

}
