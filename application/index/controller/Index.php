<?php
namespace app\index\controller;

use app\common\model\Common;
use app\common\model\VyangAdminPush;
use think\Controller;
use think\Db;
use app\common\controller\Api;
class Index extends Controller
{
    //第一次执行
    public function _initialize()
    {
        parent::_initialize();
        //系统配置转换前
        $this->system_set = Db::name('admin_set')->select();
        $data = [];
        foreach ($this->system_set as $k => $v) {
            $data[$v['set_cname']] = $v['set_cvalue'];
        }
        //分隔一下 上传后缀
        $data['extension']  = explode(',', $data['extension']);
    }
	//主页
    public function index()
    {
        //获取当前网址
        return '';
    }
}
