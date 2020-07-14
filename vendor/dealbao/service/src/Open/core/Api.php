<?php
namespace Dealbao\Open\core;

use Dealbao\Open\base\Http;
use Dealbao\Open\core\RequestUrl;

class Api
{

    private $accessToken;
    
    public function __construct(string $accessToken)
    {
        $this->accessToken = $accessToken;

    }

    /**请求
     * @param $method
     * @param array $params
     */
    public function request($path,array $params = [],$request_type = 'POST',$signature=null){

        $params['access_token'] = $this->accessToken;

        $signature &&  $params['signature'] = Helper::createSinature($params);
        //var_dump($params);die;
        $res = Http::curlRequest(RequestUrl::buildRequestUrl($path),$params,$request_type);
        //var_dump($res);die;
        !empty($res['signature']) && Helper::checkSignature($res);

        return $res;
    }


}