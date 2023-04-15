<?php
namespace app\admin\model;

use think\Model;
use think\Db;
use think\Session;
use think\Cookie;
use app\common\controller\Common;
class User extends Model
{
    //判断登陆
    static public function checkLogin($post)
    {
        //判断当前IP是否暂时无法登陆(登陆次数过多暂时封掉)
//        $_check_ip_login = self::_check_ip_login($post['ip']);
//        if(!$_check_ip_login)
//        {
//            return '0';
//        }
        //判断账户名和密码是否正确
        $user_info = Db::name('admin')->where(['username' =>$post['username'] ])->find();
        if(empty($user_info))
        {
            //记录日志
            self::saveLoginLog($post,'0','账户名不存在');
            //账户名不存在
            return '1';
        }
        if(password_verify ($post['password'],$user_info['password'])){
            //判断是否被管理员禁止登陆
            if($user_info['status'] != '1')
            {
                //记录日志
                self::saveLoginLog($post,'0','此账号已被禁止登陆');
                return '2';
            }
            //记录日志 需要修改密码为加密的密码
            $post['password'] = $user_info['password'];
            self::saveLoginLog($post,'1','登录成功');
            //执行缓存用户session和cookie
            self::saveUserInfo($post);
            return '3';
        }else{
            //记录日志
            self::saveLoginLog($post,'0','密码不正确');
            //密码不正确
            return '1';
        }
    }
    //判断当前IP是否暂时无法登陆(登陆次数过多暂时封掉)
    static public function _check_ip_login($ip)
    {
        //查询1小时内登陆次数如果超过10次则无法登陆
        $where = [
            'admin_login_ip'     =>  ['eq',$ip],
            'admin_login_status' =>  ['eq','0'],
            'admin_login_time'   =>  ['<',time()+(60*60+1)]
        ];
        $count = Db::name('admin_login')->where($where)->count();
        if($count >= 10)
        {
            return false;
        }else{
            return true;
        }
    }
    //记录登陆日志
    static public function saveLoginLog($post,$user_login_status,$user_login_reason='')
    {

        $log['admin_login_username'] = $post['username'];
        $log['admin_login_password'] = $post['password'];
        $log['admin_login_status']   = $user_login_status;
        $log['admin_login_ip']       = $post['ip'];
        $log['admin_login_head']     = $post['head'];
        $log['admin_login_reason']   = $user_login_reason;
        $log['admin_login_time']     = time();
        //写入登陆时间和IP到数据库
        Db::name('admin_login')->insert($log);
    }

    //执行缓存用户session和cookie
    static public function saveUserInfo($post)
    {
        //先清除缓存再存入
        Session::delete('userinfo');
        if (!empty(Cookie::has('userinfo')))
        {
            Cookie::delete('userinfo');
        }
        $userinfo = [
            'username'  =>  $post['username'],
            'ip'        =>  $post['ip'],
            'password'  =>  $post['password']
        ];
        //存session
        Session::set('userinfo',$userinfo);
        //存cookie
        if($post['remember'] == '1')
        {
            //cookie过期时间  60*60*24*14 2周
            $res = Common::get_system();
            $data = Common::encrypt($userinfo);
            $time = 1209600;
            //将加密后的用户数据存储到cookie中
            Cookie::set('userinfo',$data,$time);
        }
    }
}