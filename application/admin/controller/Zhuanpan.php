<?php
namespace app\admin\controller;

use app\common\model\VyangAdminPush;
use think\Db;
use think\Request;
use app\admin\model\Common as adminModelCommon;

/**
 * 订单
 * Class Cash
 * @package app\admin\controller
 */
class Zhuanpan extends Common
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
        $this->assign('active','17');
    }

    public function zhuanpan_list()
    {
        // 查询数据 并且每页显示10条数据
        $cont    = $this->request->get('cont');
        $type       = $this->request->get('type');
        $status     = $this->request->get('status');
        $lei     = $this->request->get('lei');


        $map    = [];
        $page = '';


        $list   = PageSeach('zhuanpan', $map,[], 'zp_id desc', '10', false, Request::instance()->param());

        if(!empty($list))
        {
            $page = $list->render();
            $list = $list->all();
            foreach ($list as $k => $v)
            {
                $list[$k]['time']            = replaceTime($v['time']);
            }
        }
        if(!empty($list))
        {
            $list = _xss($list);
        }
        // 把分页数据赋值给模板变量list
        $this->assign('order',$list);
        $this->assign('type',$type);
        $this->assign('status',$status);
        $this->assign('lei',$lei);
        $this->assign('show',$page);
        // 渲染模板输出

        return $this->fetch();
    }

    public function zhuanpan_add(){
        return $this->fetch();
    }

    public function zhuanpan_add_sub(){
        $name    = $this->request->post('name');
        $img    = $this->request->post('img');
        $gailv   = $this->request->post('gailv');

        if(empty($name)){
            ajaxError('名称不能为空');
        }
        if(empty($img)){
            ajaxError('图片不能为空');
        }
        if(empty($gailv)){
            ajaxError('概率不能为空');
        }

        $data = [
          'name' => $name,
          'img' => $img,
          'gailv' => $gailv,
          'time' => time(),
        ];

        $re = Db::name('zhuanpan')->insertGetId($data);
        if($re){
            ajaxSuccess('成功');
        }else{
            ajaxError('当前人数较多，请稍后再试');
        }
    }

    public function zhuanpan_edit(){
        $zp_id    = $this->request->get('id');
        if(empty($zp_id)){
            ajaxError('id不能为空');
        }

        $re = Db::name('zhuanpan')->where('zp_id',$zp_id)->find();
        $this->assign('re',$re);

        return $this->fetch();
    }

    public function zhuanpan_edit_sub(){
        $zp_id    = $this->request->post('zp_id');
        $name    = $this->request->post('name');
        $img    = $this->request->post('img');
        $gailv   = $this->request->post('gailv');

        if(empty($name)){
            ajaxError('名称不能为空');
        }
        if(empty($img)){
            ajaxError('图片不能为空');
        }
        if(empty($gailv)){
            ajaxError('概率不能为空');
        }

        $data = [
            'name' => $name,
            'img' => $img,
            'gailv' => $gailv,
            'time' => time(),
        ];

        $re = Db::name('zhuanpan')->where('zp_id',$zp_id)->update($data);
        if($re){
            ajaxSuccess('成功');
        }else{
            ajaxError('当前人数较多，请稍后再试');
        }
    }

    public function zhuanpan_delete_sub(){
        $zp_id    = $this->request->post('id');

        if(empty($zp_id)) {
            ajaxError('参数不能为空');
        }

        $re = Db::name('zhuanpan')->where('zp_id',$zp_id)->delete();
        if($re){
            ajaxSuccess('成功');
        }else{
            ajaxError('当前人数较多，请稍后再试');
        }
    }


}