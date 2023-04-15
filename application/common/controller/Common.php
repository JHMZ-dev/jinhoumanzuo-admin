<?php
namespace app\common\controller;

use think\Controller;
use think\Db;

/**
 * Class Common
 * @package app\common\controller
 */
class Common extends Controller
{
    /**
     * 读取系统配置
     * @param bool $arr
     * @return array|false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    static public function get_system($arr = true){
        $res = Db::name('admin_set')->select();
        if($arr){
            //系统配置转换后
            $data = [];
            foreach ($res as $k => $v) {
                $data[$v['set_cname']] = $v['set_cvalue'];
            }
            //分隔一下 上传后缀
            $data['extension']  = explode(',', $data['extension']);
            return $data;
        }else{
            //系统配置转换前
            return $res;
        }
        
    }

    /**
     * 要加密的数据
     * @param $input
     * @return array|false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    static public function encrypt($input)
    {
        $data = self::get_system();
        $key  = $data['set_key'];
        $key  = base64_decode(md5($key));//加密密钥
        $str  = serialize($input);//将加密的数据序列化
        $data = base64_encode(openssl_encrypt($str, 'AES-128-ECB', $key, OPENSSL_RAW_DATA)); //加密
        return $data;
    }

    /**
     * 要解密的数据
     * @param $input
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    static public function decrypt($input)
    {
        $data = self::get_system();
        $key  = $data['set_key'];
        $key  = base64_decode(md5($key));//加密密钥
        $decrypted = openssl_decrypt(base64_decode($input), 'AES-128-ECB', $key, OPENSSL_RAW_DATA); //解密
        $undecrypted = unserialize($decrypted); //反序列化
        return $undecrypted;
    }
}