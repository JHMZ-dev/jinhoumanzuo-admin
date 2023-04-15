<?php
namespace app\admin\controller;

use think\Controller;
use think\Session;
use think\Cookie;
use app\admin\model\User as UserModel;
use dingxiang\CaptchaClient;
use think\Request;

/**
 * 登录
 * Class Login
 * @package app\admin\controller
 */
class Login extends Controller
{
    /**
     * 登陆页面
     * @return mixed
     */
    public function index()
    {
        return $this->fetch();
    }

    /**
     * 验证登陆
     */
    public function checkLogin()
    {
        header('Access-Control-Allow-Origin:*');
        //设置过滤方法
        $this->request->filter(['strip_tags']);
        $token = $this->request->post('token');
        //判断验证码是否正确
//        $this->_check_new_code($token);
        //判断密码
         $post = $this->request->post();
         if(empty($post['username']) || empty($post['password']))
         {
             return jsonError('10001','用户名或密码不能为空！');
         }
         if(empty($post['remember']))
         {
             $post['remember'] = '0';
         }
        //判断登陆
        $post['ip'] = $this->request->ip();
        $post['head'] = Request::instance()->header('user-agent','');  //user-agent
        $res = UserModel::checkLogin($post);
        switch ($res)
        {
            case '0':
                return jsonError('10001','登陆次数过多！请于一小时候再试！');
                break;
            case '1':
                return jsonError('10001','用户名或者密码不正确！');
                break;
            case '2':
                return jsonError('10001','此账号已被禁止登陆！');
                break;
            case '3':
                return jsonSuccess('200','登陆成功！');
                break;
        }
    }

    /**
     * 判断验证码是否正确
     * @param $token
     * @return bool|void
     */
    protected function _check_new_code($token)
    {
        /**
         * 构造入参为appId和appSecret
         * appId和前端验证码的appId保持一致，appId可公开
         * appSecret为秘钥，请勿公开
         * token在前端完成验证后可以获取到，随业务请求发送到后台，token有效期为两分钟
         **/
        $appId = "982f0301767f71cfe2903b86ed6895d9";
        $appSecret = "447f8a55f2bcde7d22868e5d36fdd03f";
        $client = new CaptchaClient($appId,$appSecret);
        $client->setTimeOut(2);      //设置超时时间
        # $client->setCaptchaUrl("http://cap.dingxiang-inc.com/api/tokenVerify");   //特殊情况需要额外指定服务器,可以在这个指定，默认情况下不需要设置
        $response = $client->verifyToken($token);
        if($response->serverStatus == 'SERVER_SUCCESS' && $response->result == '1')
        {
            return true;
        }else
        {
            return jsonError('10001','验证码不正确！');
        }
        // echo $response->serverStatus;
        // //确保验证状态是SERVER_SUCCESS，SDK中有容错机制，在网络出现异常的情况会返回通过
        // if($response->result){
        //     echo "true";
        //     /**token验证通过，继续其他流程**/
        // }else{
        //     echo "false";
        //     /**token验证失败**/
        // }
    }

    /**
     * 注销
     */
    public function out()
    {
        Session::delete('userinfo');
        if (!empty(Cookie::has('userinfo'))) {
            Cookie::delete('userinfo');
        }
        return jsonSuccess('200','操作成功！');
    }
}
