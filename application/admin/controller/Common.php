<?php
namespace app\admin\controller;

use think\Controller;
use think\Session;
use think\Cookie;
use think\Request;
use think\Db;
use app\admin\model\User as UserModel;
use app\common\controller\Common as Common1;

/**
 * 权限验证
 * Class Common
 * @package app\admin\controller
 */
class Common extends Controller
{
    //第一次执行
    protected function _initialize()
    {
        header('Access-Control-Allow-Origin:*');
        //设置过滤方法
        $this->request->filter(['strip_tags']);
        //自动登陆
        $this->checkLogin();
        //纪录一下访问日志
        $this->produceViewLogs($this->userInfo['username']);

//        //判断是否是admin
//        $arr = [
//            '今后满座',
//        ];
//        if(!in_array($this->userInfo['username'],$arr))
//        {
//            $this->error('没有登录,正在跳转登录',url('/sun_admin/login'),'',2);
//            exit;
//        }

        //权限验证 begin
        $user = $this->userInfo;
        $roleid = $user['role_id'];
        $this->assign('roleid',$roleid);
        $this->assign('adminid',$user['id']);
        $control = lcfirst(request()->controller());
        $action = lcfirst(request()->action());
        $request_op = $control.'/'.$action;
        //查询当前用户权限
        $is_quanxian = authCheck($request_op,$roleid);
        if(!$is_quanxian){
            if (Request::instance()->isAjax())
            {
                ajaxError('没有权限！');
            }else{
                $this->error('没有权限！联系管理员');
            }
        }
        //权限验证 end

        //加载管理员昵称
        $this->assign('title',$this->userInfo['title']);
        $this->assign('username',$this->userInfo['username']);
        //加载redis
        $this->xiao_redis = new \Redis();
        $this->xiao_redis->connect('127.0.0.1','6379');
        $this->xiao_redis->auth(NULL);
    }
    /**
     * 统计不同用户的不同页面的浏览量
     */
    private function produceViewLogs($name)
    {
        //获取模块名
        $viewDatas['module']       = request()->module();
        //获取控制器名
        $viewDatas['controller']   = request()->controller();
        //获取方法名
        $viewDatas['action']       = request()->action();
        $param                     = $this->request->param();               //post数据
        $viewDatas['datas']        = json_encode($param);
        $viewDatas['ip']           = $this->request->ip();                 //ip
        $viewDatas['useragent']    = Request::instance()->header('user-agent','');  //user-agent
        $viewDatas['time']         = time();
        $viewDatas['name']         = $name;
        //添加纪录
        Db::name('admin_viewlogs')->insert($viewDatas);
    }

    /**
     * 自动登陆
     */
    private function checkLogin()
    {
        // 开启会话跟踪
        @session_start();
        //判断session
        $userinfo = Session::get('userinfo');
        if(!empty($userinfo)){
            //检查账户是否存在以及是否能登录
            $this->_check_fast_login_user($userinfo,'1');
        }else{
            //判断cookie
            $userinfo = Cookie::get('userinfo');
            if(empty($userinfo)){
                $this->error('没有登录,正在跳转登录',url('/sun_admin/login'),'',2);
                exit;
            }else{
                //获取cookie信息
                $uinfo = Common1::decrypt($userinfo);
                //检查账户是否存在以及是否能登录
                $this->_check_fast_login_user($uinfo,'2');
                //存入session
                Session::set('userinfo',$uinfo);
            }
        }
    }
    //检查账户是否存在以及是否能登录
    private function _check_fast_login_user($userinfo,$is_session_cookie)
    {
        $post['username']   = $userinfo['username'];
        $post['password']   = $userinfo['password'];
        $post['ip']         = $this->request->ip();
        $post['head']       = Request::instance()->header('user-agent','');  //user-agent
        $where = [
            'username'     =>  $userinfo['username'],
            'status'       =>  '1',
            'password'     =>  $userinfo['password']
        ];
        $res = Db::name('admin')->where($where)->find();
        if(!empty($res))
        {
            //登录成功  存入数据
            $this->userInfo = $res;
            //记录登录日志
            if($is_session_cookie == '1')
            {
//                UserModel::saveLoginLog($post,'1','session缓存登录成功');
            }else
            {
                UserModel::saveLoginLog($post,'1','cookie缓存登录成功');
            }
        }else
        {
            //登录失败  记录登录日志
            if($is_session_cookie == '1')
            {
                UserModel::saveLoginLog($post,'0','session缓存不存在');
            }else
            {
                UserModel::saveLoginLog($post,'0','cookie缓存不存在');
            }
            $this->error('没有登录,正在跳转登录',url('/sun_admin/login'),'',2);
            exit;
        }
    }
}