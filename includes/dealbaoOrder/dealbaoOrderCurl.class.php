<?php
/**
 * Created by PhpStorm.
 * User: BXY
 * Date: 2020/5/29
 * Time: 16:02
 */
include DEALBAO_PLUGIN_DIR.'/includes/Curl.php';
require_once DEALBAO_PLUGIN_DIR . '/vendor/autoload.php';
class dealbaoOrderCurl
{

    private $Client ;
    public function __construct()
    {


        session_start();
        if(!isset($_SESSION['accessToken'])){
            $this->dealbaoNewAccessToken();
        }else{
//            $config['access_token'] = 'FFD0FA6926D9E3E763CBA1B9B8DF6493';
            $config['access_token'] = $_SESSION['accessToken'];
            $this->Client = new \Dealbao\Open\Client($config);
        }


    }
    function dealbaoGetOrderList($keyword=[]){


        $keyword['size'] = 10;

        $data =   $this->Client->Order->getOrderList($keyword);
        if($data['code']==1000012 ){
            $this->dealbaoNewAccessToken();

            $this->dealbaoGetOrderList($keyword);

        }
        return $data;

    }
//    function dealbaoGetOrderList($keyword=[]){
//
//        if (!current_user_can('manage_options'))
//            wp_die(__('You do not have the sufficient permissions to access this page.'));
//        $dealbao_options = get_option('dealbao_option_name');
//        $time = time();
//        $sign = strtoupper(md5(esc_attr($dealbao_options['appkey']) . $dealbao_options['secret'] . $time));
//        $keyword['appId'] = $dealbao_options['appid'];
//        $keyword['pageSize'] = 10;
//        $getOrderUrl = 'order/getOrderList';
//        $orderData = ['body' =>   $keyword, 'headers' => ['appKey' => $dealbao_options['appkey'], 'sign' => $sign, 'timestamp' => $time]];
//        $curl = new Curl();
//        $data = $curl->PostCurl($getOrderUrl, $orderData);
//        return $data;
//    }

    function dealbaoGetOrderDetail($keyword=[]){

        if (!current_user_can('manage_options'))
            wp_die(__('You do not have the sufficient permissions to access this page.'));
        $dealbao_options = get_option('dealbao_option_name');
        $time = time();

        $sign = strtoupper(md5(esc_attr($dealbao_options['appkey']) . $dealbao_options['secret'] . $time));
        $keyword['appId'] = $dealbao_options['appid'];

        $getOrderUrl = 'order/orderDetail';
        $orderData = ['body' =>   $keyword, 'headers' => ['appKey' => $dealbao_options['appkey'], 'sign' => $sign, 'timestamp' => $time]];
        $curl = new Curl();
        $data = $curl->PostCurl($getOrderUrl, $orderData);
        return $data;
    }

    function dealbaoNewAccessToken(){

        if (!current_user_can('manage_options'))
            wp_die(__('You do not have the sufficient permissions to access this page.'));
        $dealbao_options = get_option('dealbao_option_name');
        $config['appid'] = $dealbao_options['appid'];
        $config['secret'] = $dealbao_options['secret'];
        $config['appkey'] = $dealbao_options['appkey'];
        $Client = new \Dealbao\Open\Client($config);
        $res = $Client->AccessToken->getAccessToken();
        if($res['code']==200){
            $_SESSION['accessToken'] = $res['data']['access_token'];
        }else{
            wp_die(__('Interface Error','dealbao'));
        }

        $config['access_token'] = $_SESSION['accessToken'];
        $this->Client = new \Dealbao\Open\Client($config);

    }
}