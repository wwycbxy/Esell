<?php
/**
 * curl基类
 */
namespace Dealbao\Open\base;

class Http{
    /**
     * 发送http请求
     * @param string $url 请求地址
     * @param string $method http方法(GET POST PUT DELETE)
     * @param array $data http请求数据
     * @param array $header http请求头
     * @param Int   $type  请求数据类型 0-array  1-json
     * @return string|bool
     */
    public static function curlRequest($url , $data = array(),$method = "POST",  $header = array(), $type = '0') {
        //检查地址是否为空
        if (empty($url)) {
            return false;
        }
        //控制请求方法范围
        $httpMethod = array('GET', 'POST', 'PUT', 'DELETE');
        $method = strtoupper($method);
        if (!in_array($method, $httpMethod)) {
            return false;
        }
        //请求头初始化
        $request_headers = array();
        $User_Agent = 'Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31';
        $request_headers[] = 'User-Agent: '. $User_Agent;
        if($header){
            foreach ($header as $v) {
                $request_headers[] = $v;
            }
        }
        $request_headers[] = 'Accept: text/html,application/json,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8';
        $request_headers[] = "X-HTTP-Method-Override: ".$method;
        //发送http请求
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);//https
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        //curl_setopt($ch, CURLOPT_USERAGENT,$User_Agent);
        switch ($method) {
            case "POST":
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                break;
            case "PUT":
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                break;
            case "DELETE":
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
                break;
            default:
        }

        //格式化发送数据
        if($data) {
            if ($type) {
            }else{
                $dataValue = http_build_query($data);
            }
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dataValue);
        }
        //发送请求获取返回响应
        $result = curl_exec($ch);

        if(strlen(curl_error($ch))>1){
            $result['success'] = false;
        }else{
            $result = json_decode($result,true);
        }
        //$result['http_code'] = curl_getinfo($ch,CURLINFO_HTTP_CODE);
        curl_close($ch);
        return $result;
    }
    public static function curlPost($url,$data =array())
    {
        $data =  json_encode($data);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data)
        ));
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            print curl_error($ch);
        }
        curl_close($ch);
        return $result;
    }

}
