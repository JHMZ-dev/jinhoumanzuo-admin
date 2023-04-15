<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
use app\common\controller\Common;
use OSS\Core\OssException;
use OSS\OssClient;
use think\Db;
use think\Image;
use think\Loader;
use think\cache\driver\Redis;

use think\File;

use Qiniu\Config;
use Qiniu\Auth; //获取上传token
use Qiniu\Storage\UploadManager;    //上传
use Qiniu\Storage\BucketManager;    //删除

/**
 * @param $async
 * @return \Redis
 */
function get_redis_config($async)
{
    $redis = new \Redis();
    $redis->connect('127.0.0.1','6379');
    $redis->auth(NULL);
    $redis->select((int)$async);
    return $redis;
}
/**
 * 生成签名
 * @param $datas
 * @return string
 * @throws \think\db\exception\DataNotFoundException
 * @throws \think\db\exception\ModelNotFoundException
 * @throws \think\exception\DbException
 */
function signature($datas)
{
    $res = Common::get_system();
    $signature = '';

    ksort($datas);
    foreach ($datas as $paramName => $paramValue) {
        $signature .= $paramName . $paramValue;
    }
    $signature .= $res['key'];

    return md5($signature);
}

/**
 * 产生验证码
 * @return int
 */
function code()
{
    return mt_rand(100000,999999);
}

/**
 * 返回json数据，并结束
 * @param $datas
 */
function ajaxReturn($datas)
{
    header('Content-type:text/json');
    header('Content-type:application/json');
    echo json_encode($datas);
    exit;
}

/**
 * 返回成功的json数据，并结束
 * @param string $msg
 * @param string $status
 * @param array $data
 */
function ajaxSuccess($msg='',$status='200',$data=[])
{
    header('Content-type:text/json');
    header('Content-type:application/json');
    echo json_encode([
        'status'    => $status,
        'msg'       => $msg,
        'datas'     => $data,
    ]);
    exit;
}

/**
 * 返回失败的json数据，并结束
 * @param string $msg
 * @param string $status
 * @param array $data
 */
function ajaxError($msg='',$status='10001',$data=[])
{
    header('Content-type:text/json');
    header('Content-type:application/json');
    echo json_encode([
        'status'    => $status,
        'msg'       => $msg,
        'datas'     => $data,
    ]);
    exit;
}
/**
 * 返回成功的json数据，并结束
 * @param string $status
 * @param string $msg
 * @param array $data
 */
function jsonSuccess($status='200',$msg='',$data=[])
{
    header('Content-type:text/json');
    header('Content-type:application/json');
    echo json_encode([
        'status'    => $status,
        'msg'       => $msg,
        'datas'     => $data,
    ]);
    exit;
}

/**
 * 返回失败的json数据，并结束
 * @param string $status
 * @param string $msg
 * @param array $data
 */
function jsonError($status='500',$msg='',$data=[])
{
    header('Content-type:text/json');
    header('Content-type:application/json');
    echo json_encode([
        'status'    => $status,
        'msg'       => $msg,
        'datas'     => $data,
    ]);
    exit;
}

/**
 * 普通上传 上传到当前服务器
 * @param $file
 * @return array
 * @throws \think\db\exception\DataNotFoundException
 * @throws \think\db\exception\ModelNotFoundException
 * @throws \think\exception\DbException
 */
function upload($file)
{
  if(!empty($file)){
      $system = Common::get_system();
      $time = date('Ymd');
      $config = [
        'size'  => $system['uploadsize'] * 1000,
        'ext'   => implode(',',$system['extension']),
      ];
      $info = $file->validate($config)->move(ROOT_PATH . 'public' . DS . 'uploads');
      if($info){
          $filename = $info->getFilename();
          // 成功上传后 获取上传信息
          $xiangdui = $system['picurl'].'/'.'/uploads/'.$time .'/'.$filename;
          return [
              'status'    => 200,
              'msg'       => '上传成功',
              'datas'     => [
                        'url'     => $xiangdui,
                        'filename' => '/uploads/'.$time .'/'.$filename
                  ]
          ];
      }else{
          // 上传失败获取错误信息
          return [
              'status'    => 10001,
              'msg'       => $file->getError(),
              'datas'     => ''
          ];
      }
  }
}


/**
 * 时间转换
 * @param $value
 * @return false|string
 */
function replaceTime($value)
{
    return date("Y-m-d H:i:s", $value);
}

/**
 * 判断是否是今天
 * @param $time
 * @return bool
 */
function is_today($time)
{
    if(!empty($time)){
        $today = date('Y-m-d');
        $time  = date('Y-m-d',$time);
        if($today == $time){
            return true;
        }else{
            return false;
        }
    }else{
        return false;
    }
}

/**
 * 打印输出
 * @param array $arr
 */
function pr($arr = [])
{
    echo "<pre>";print_r($arr);echo "</pre>";
}

/**
 * 返回今日日期 不包括时分秒
 * @return false|int
 */
function date2()
{
    return strtotime(date('Y-m-d'));
}

/**
 * 字符串模糊查找
 * @param $needle   //要包含的字符串
 * @param $str      //要查找的字符串内容
 * @return bool
 */
function check_mohu_str($needle,$str)
{
    $tmparray = explode($needle,$str);
    if(count($tmparray)>1){
        return true;
    }else{ 
        return false; 
    }
}

/**
 * name     string  表名
 * where    array   搜索条件
 * whereOr  array   多条件搜索
 * limit    string  搜索条件
 * simple   bool    显示页数
 * param    string  保留原始url参数
 * field    string  指定字段
 * return   array   返回数据集
 */
function PageSeach($name,$where = [], $whereOr = [], $order = '', $limit = 10, $simple = false, $param = '',$field = '')
{
    if(empty($name)){
        return '表名不能为空';
    }
    return Db::name($name)->where($where)->whereOr($whereOr)->order($order)->field($field)->paginate($limit,$simple,['query' => $param]);
}

/**
 * name     string  表名
 * where    array   搜索条件
 * whereOr  array   多条件搜索
 * limit    string  搜索条件
 * simple   bool    显示页数
 * param    string  保留原始url参数
 * field    string  指定字段
 * return   array   返回数据集
 */
function PageSeach2($name,$where = [], $whereOr = [], $order = '', $limit = 10, $simple = false, $param = '',$field = '')
{
    if(empty($name)){
        return '表名不能为空';
    }
    return Db::table($name)->where($where)->whereOr($whereOr)->order($order)->field($field)->paginate($limit,$simple,['query' => $param]);
}

/**
 * 数组 转 对象
 *
 * @param array $arr 数组
 * @return object
 */
function array_to_object($arr) {
    if (gettype($arr) != 'array') {
        return;
    }
    foreach ($arr as $k => $v) {
        if (gettype($v) == 'array' || getType($v) == 'object') {
            $arr[$k] = (object)array_to_object($v);
        }
    }
 
    return (object)$arr;
}
 
/**
 * 对象 转 数组
 *
 * @param object $obj 对象
 * @return array
 */
function object_to_array($obj) {
    $obj = (array)$obj;
    foreach ($obj as $k => $v) {
        if (gettype($v) == 'resource') {
            return;
        }
        if (gettype($v) == 'object' || gettype($v) == 'array') {
            $obj[$k] = (array)object_to_array($v);
        }
    }
 
    return $obj;
}

/**
 * 已倒序/顺序的方式排序指定数组值的内容
 * $data      数据
 * $zhi       指定值
 * $fangshi   方式 true 正序  false 倒叙
 */
function arr_paixu($data,$zhi,$fangshi = false)
{
    // 取得列的列表
    foreach ($data as $key => $row)
    {
        $volume[$key]  = $row[$zhi];
    }
    if($fangshi){
        array_multisort($volume, SORT_ASC, $data);
    }else{
        array_multisort($volume, SORT_DESC, $data);
    }
    return $data;
}

/**
 *
 * @param string $name  为表格设置名称
 * @param array $title  标题头部数组
 * @param array $datas  数据
 * @param string $path  保存路径
 * @return string
 * @throws \PHPExcel_Exception
 * @throws \PHPExcel_Reader_Exception
 * @throws \PHPExcel_Writer_Exception
 */
function wps($name='',$title =[],$datas =[],$path ='/data.xlsx')
{
//         引入文件
    Loader::import('PHPExcel.Classes.PHPExcel', VENDOR_PATH);
    Loader::import('PHPExcel.Classes.PHPExcel.IOFactory.PHPExcel_IOFactory', VENDOR_PATH);

    // 构造PHPExcel对象
    $PHPExcel = new \PHPExcel();

    // 获取活动的sheet
    $PHPSheet = $PHPExcel->getActiveSheet();

    // 给当前活动的sheet设置名称
    $PHPSheet->setTitle($name);

    //设置标题
    foreach ($title as $k => $one) {
        $ord = chr( ord('A') + $k);
        $PHPSheet->setCellValue($ord . '1', $one);
    }

    // 设置数据
    $datas = array_merge($datas);
    $column = 2;
    foreach ($datas as $k => $v1)
    {
        $span  = ord("A");
        $span2 = ord("A");
        $j2    ='';
        foreach ($v1 as $k2 => $v2)
        {
            $j = chr($span);
            $PHPSheet->setCellValueExplicit($j2.$j.$column,$v2,\PHPExcel_Cell_DataType::TYPE_STRING);
            if($span < 90)
            {
                $span += 1;
            }else{
                $span = ord("A");
                $j2 = chr($span2);
                $span2++;
            }
        }
        $column++;
    }

    // 创建IOFactory对象
    $PHPWriter = \PHPExcel_IOFactory::createWriter($PHPExcel,"Excel2007");

    // 保存表格
    $PHPWriter->save($path);
    return 'ok';
}

/**
 * 返回执行的操作结果
 * @param $res
 */
function caozuo($res)
{
    if($res){
        jsonError('200','操作成功');
    }else{
        jsonError('10001','操作失败，请稍后重试');
    }
}

/**
 * 上传到阿里云oos
 * @param $file
 * @return array
 * @throws \think\db\exception\DataNotFoundException
 * @throws \think\db\exception\ModelNotFoundException
 * @throws \think\exception\DbException
 */
function upload_ali($file)
{
    @error_reporting (E_ALL & ~E_NOTICE & ~E_WARNING);

    $resResult = Image::open($file);
    //$res = Common::get_system();
//    $accessKeyId = $res['alioss_ak'];
//    $accessKeySecret = $res['alioss_aks'];
//    // Endpoint以杭州为例，其它Region请按实际情况填写。
//    $endpoint = $res['alioss_ep'];
//    $bucket   = $res['alioss_bk'];
    
    $res = [
        'alioss_ak_shangjia' => 'LTAI5tE8iguurb4wVa3A2yxf',
        'alioss_aks_shangjia' => 'X9i0AZu5ORk3WAal9d1opAXjsmAy8D',
        'alioss_ep_shangjia' => 'oss-cn-hangzhou.aliyuncs.com',
        'alioss_bk_shangjia' => 'jinhoumanzuo',
    ];

    $accessKeyId = $res['alioss_ak_shangjia'];
    $accessKeySecret = $res['alioss_aks_shangjia'];
    // Endpoint以杭州为例，其它Region请按实际情况填写。
    $endpoint = $res['alioss_ep_shangjia'];
    $bucket   = $res['alioss_bk_shangjia'];


    // 尝试执行
    try {
        //实例化对象 将配置传入
        $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
        //这里是有sha1加密 生成文件名 之后连接上后缀
        $dd = 'uploads'.'/'.date('Y').'/'.date('m').'/'.date('d').'/'. md5(time());
        $fileName = $dd . '.' . $resResult->type();
        //执行阿里云上传
        $result = $ossClient->uploadFile($bucket, $fileName, $file->getInfo()['tmp_name']);
        return [
            'status'    => '200',
            'msg'       => '上传成功',
            'url'       => $result['info']['url']
        ];
    } catch (OssException $e) {
        return [
            'status'    => '10001',
            'msg'       => $e->getMessage(),
            'url'       => ''
        ];
    }
}

/**
 * post请求json数据
 * @param $url          //url
 * @param array $data   //数据
 * @param array $head   //head头
 * @param bool $json    //返回格式
 * @return bool|mixed|string
 */
function https_post($url,$data = [],$head = [],$json = true)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);          //单位 秒，也可以使用
    #curl_setopt($ch, CURLOPT_NOSIGNAL, 1);     //注意，毫秒超时一定要设置这个
    #curl_setopt($ch, CURLOPT_TIMEOUT_MS, 200); //超时毫秒，cURL 7.16.2中被加入。从PHP 5.2.3起可使用
    if(check_mohu_str('https',$url))
    {
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); //对认证证书来源的检查
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); //从证书中检查SSL加密算法是否存在
    }
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, 0); //是否头文件信息
    if(!empty($head))
    {
        curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
    }
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
 * 更新缓存用户信息
 * @param $user_id
 * @throws \think\db\exception\DataNotFoundException
 * @throws \think\db\exception\ModelNotFoundException
 * @throws \think\exception\DbException
 */
function update_user_info($user_id)
{
    $user_id = strval($user_id);
    $redis = get_redis_config(1);

    //获取用户信息剩余时长
    $ttl = $redis->ttl($user_id);
    if ($ttl && $ttl > 0)
    {
        //查询用户信息
        $userInfo = Db::name('user')->where('user_id', $user_id)->find();
        //保存用户信息
        $redis->set($user_id, json_encode($userInfo));
        //设置过期时间
        $redis->expire($user_id, $ttl);
    }
}

function _xss($data)
{
    if(is_array($data))
    {
        if(count($data) == count($data,1))
        {
            foreach ($data as $k => $v)
            {
                $data[$k] = htmlentities($v);
            }
            return $data;
        }else{
            foreach ($data as $k => $v)
            {
                foreach ($v as $k2 =>  $v2)
                {
                    $data[$k][$k2] = htmlentities($v2);
                }
            }
            return $data;
        }

    }else{
        return htmlentities($data);
    }
}
function is_url($v)
{
    $v =strval($v);
    $pattern="#(http|https)://(.*\.)?.*\..*#i";
    if(preg_match($pattern,$v)){
        return true;
    }else{
        return false;
    }
}


/**
 * 上传到qiniu
 * @param $file
 * @return array
 * @throws \think\db\exception\DataNotFoundException
 * @throws \think\db\exception\ModelNotFoundException
 * @throws \think\exception\DbException
 */
function upload_qiniu($file)
{
    $user_id       = mt_rand(10000,99999);
    //获取配置信息
    //执行上传

    //配置
    $redis = get_redis_config(0);

    //$qiniuredis = json_decode($redis->get('qiniu_pz'),true);
    $bucket    = $redis->get('qnybk');
    $accessKey = $redis->get('qnyak');
    $secretKey = $redis->get('qnysk');
    $qnyurl  = $redis->get('qnyurl');

    $expires = 6000;
    $auth = new Auth($accessKey, $secretKey);
    $policy = array(
        'callbackBody' => 'key=$(key)&hash=$(etag)&bucket=$(bucket)&fsize=$(fsize)&name=$(x:name)',
        'callbackBodyType' => 'application/json'
    );

    //不存在则上传文件
    $ex = strtolower(pathinfo($file->getInfo()['name'],PATHINFO_EXTENSION));
    //获取配置中的信息
    $extension = ['jpg','jpeg','png','gif','bmp','pdf','xlsx','rtf','mp4','mp3','rm','rmvb','mkv','3gp','mov','zip'];
    //$extension = ['jpg','jpeg','png','gif','pdf','xlsx','mp4','zip'];

    //判断后缀是否允许上传
    if(!in_array($ex,$extension))
    {
        ajaxError('不允许上传该类型');
        return false;
    }

    //限制上传大小
    $xianzhi = 80000;
    if($file->getInfo()['size']/1024 > $xianzhi){
        ajaxError('文件过大');
        return false;
    }

    $info = [
        'file'  => $file->getPathname(),
        'ex'    => $ex
    ];

    try {
        $token = $auth->uploadToken($bucket, null, $expires, $policy, true);
        // 构建 UploadManager 对象
        $uploadMgr = new UploadManager();
        // 要上传文件的本地路径
        $filePath = $info['file'];
        $serverFilePath = 'uploads/'.date("Ymd").'/';
        // 上传到七牛后保存的文件名
        $key = md5($serverFilePath.date('Ymdhis').$user_id).'.'.$info['ex'];
        $serverFileNmae = $serverFilePath.$key;
        list($ret, $err) = $uploadMgr->putFile($token, $serverFileNmae, $filePath);

        if ($err !== null)
        {
            return false;
        } else {
            return [
                'status'    => '200',
                'msg'       => '上传成功',
                'all'       => $ret,
                'url'       => $qnyurl . '/' . $ret['key']
            ];

        }
    }catch (\Exception $e)
    {
        return [
            'status'    => '1001',
            'msg'       => '失败',
            'url'       => ''
        ];
        return false;
    }

}



/**
 * 判断是不是时间戳
 * @param int $timestamp
 * @return false|int
 */
function isTimestamp($timestamp)
{
    if (strtotime(date('Y-m-d H:i:s', $timestamp)) === $timestamp) {
        return $timestamp;
    } else {
        return false;
    }
}


/**
 * 判断是不是日期时间
 * @param string $datetime
 * @return false|int
 */
function isDatetime($datetime)
{
    return strtotime($datetime);
}


/**
 * 验证是否是有效手机号
 * @param $num
 * @return false|int
 */
function isMobile($num)
{
    if($num == NULL)
    {
        $num = '';
    }
    return preg_match("/^1[23456789]{1}\d{9}$/",strval($num));
}


/**
 * 删除用户token
 * @param $user_id
 */
function del_user_token($user_id)
{
    $redis = get_redis_config(2);
    //清除token
    $token = $redis->get($user_id.'_token');
    if($token)
    {
        $redis->del($token);
    }
    $redis->del($user_id.'_token');
}


/**
 * 权限检测
 * @param $rule
 * @param $roleid
 * @return bool
 * @throws \think\db\exception\DataNotFoundException
 * @throws \think\db\exception\ModelNotFoundException
 * @throws \think\exception\DbException
 */
function authCheck($rule,$roleid)
{
    //查询当前用户权限
    //$user = $this->userInfo;
    $res = Db::name('admin_role')->where(['id' => $roleid])->find();
    //查询当前用户节点
    if($res['rule'] !== '*'){
        $arr = explode(',',$res['rule']);
        $res_arr = Db::name('admin_node')->where('id' ,'in', $arr)->select();
        $res_arr_op = [];

        foreach ($res_arr as $k => $v)
        {
            $res_arr_op[] = $v['control_name'].'/'.$v['action_name'];
        }

        if(!in_array(strtolower($rule),$res_arr_op)){
            return false;
        }else{
            return true;
        }
    }else{
        return true;
    }
}