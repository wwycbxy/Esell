<?php
namespace Dealbao\Open\core;

use Dealbao\Open\base\Http;
use Dealbao\Open\base\HttpException;
use Dealbao\Open\Config;
use Dealbao\Open\core\RequestUrl;
class Helper
{
    /**
     * 创建signature
     */
    public static function createSinature($param = [],$secret=''){

        if(isset($param['signature']))

            unset($param['signature']);

        ksort($param);

        $secret = Config::SECRET;

        $str = http_build_query($param,'&');
        
        !empty($secret) && $str .= '&secret='.$secret;
        
        return strtoupper(md5($str));

    }

    /**
     * 验证signature正确性
     * @param array $param
     * @return bool
     */
    public static function checkSignature($param = []){
        
        $signature = self::createSinature($param['data']);
        _p($signature);
        if($signature != $param['signature']){

            self::returnError();

        }

    }

    public static function returnError($code = '500',$msg = 'wrong signature'){

        $return['code'] = $code;

        $return['msg'] = $msg;

        $return['sccess'] = false;

        exit(json_encode($return));

    }

}