<?php

namespace app\common\model;


use think\Model;

/**
 * 异步方法
 */
class VyangAdminPush extends Model
{

    /**
     * 导入注册
     * @param $id
     * @return bool|mixed|string
     */
    public static function daoru_reg($id)
    {
        $url = 'http://127.0.0.1:9510/system/import_regist';
        $info = [
            'id'      => $id,
            'key'  => config('key'),    //key
        ];
        return self::https_post($url,$info);
    }

    /**
     * 生成签名
     * @param $datas
     * @return string
     */
    public static function signature($datas)
    {
        $key    =   'dian./!@#dian';
        $signature = '';
        ksort($datas);
        foreach ($datas as $paramName => $paramValue) {
            $signature .= $paramName . $paramValue;
        }
        $signature .= $key;
        return md5($signature);
    }

    /**
     * post请求json数据
     * @param $url          //url
     * @param array $data   //数据
     * @param bool $json    //返回格式
     * @return bool|mixed|string
     */
    public static function https_post($url,$data = [],$json = true)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);          //单位 秒，也可以使用
        if(self::check_mohu_str('https',$url))
        {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); //对认证证书来源的检查
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); //从证书中检查SSL加密算法是否存在
        }
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, 0); //是否头文件信息
        $rtn = curl_exec($ch);
        curl_close($ch);
        if($json)
        {
            return json_decode($rtn,true);    //返回json对象
        }else{
            return $rtn;
        }
    }

    /**
     * 字符串模糊查找
     * @param $needle   //要包含的字符串
     * @param $str      //要查找的字符串内容
     * @return bool
     */
    public static function check_mohu_str($needle,$str)
    {
        $tmparray = explode($needle,$str);
        if(count($tmparray)>1){
            return true;
        }else{
            return false;
        }
    }
}
