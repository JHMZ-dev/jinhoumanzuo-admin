<?php



namespace app\common\model;

use think\Model;


/**

 * 错误日志

 */

class ErrorLog extends Model
{
    protected $table = 'fa_error_log';
    //增加错误日志
    public static function add_log($type,$info='',$cont = '')
    {
        $data = [
            'error_log_type'  => $type,
            'error_log_info'  => $info,
            'error_log_cont'  => $cont,
            'error_log_time'  => time()
        ];
        self::insert($data);
    }
}

