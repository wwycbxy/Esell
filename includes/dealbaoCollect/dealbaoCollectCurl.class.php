<?php
/**
 * Created by PhpStorm.
 * User: BXY
 * Date: 2020/5/29
 * Time: 16:02
 */
include DEALBAO_PLUGIN_DIR.'/includes/Curl.php';
include DEALBAO_PLUGIN_DIR.'/includes/Language.php';
require_once DEALBAO_PLUGIN_DIR . '/vendor/autoload.php';
class dealbaoCollectCurl
{
    private $language ;
    private $Client ;
    public function __construct()
    {
        $this->language = new Language();
        session_start();

        if(!isset($_SESSION['accessToken'])){
            $this->dealbaoNewAccessToken();
        }else{
            $config['access_token'] = $_SESSION['accessToken'];
            $this->Client = new \Dealbao\Open\Client($config);
        }


    }

    function dealbaoGetCollectList($keyword=[]){


        $keyword['language_id'] = $this->language->getLanguageId();
        $keyword['size'] = 10;

        $data =   $this->Client->Collect->getCollectGoodsByGroup($keyword);

        if($data['code']==1000012 ){
            $this->dealbaoNewAccessToken();

            $this->dealbaoGetCollectList($keyword);

        }
        return $data;
    }

//    function dealbaoGetGoodsList($keyword=[]){
//
//        if (!current_user_can('manage_options'))
//            wp_die(__('You do not have the sufficient permissions to access this page.'));
//        $dealbao_options = get_option('dealbao_option_name');
//        $time = time();
//
//        $sign = strtoupper(md5(esc_attr($dealbao_options['appkey']) . $dealbao_options['secret'] . $time));
//        $keyword['appId'] = $dealbao_options['appid'];
//        $keyword['languageId'] = $this->language->getLanguageId();
//        $keyword['pageSize'] = 10;
//        $getOrderUrl = '/product/page/spu';
//        $orderData = ['body' =>   $keyword, 'headers' => ['appKey' => $dealbao_options['appkey'], 'sign' => $sign, 'timestamp' => $time]];
//        $curl = new Curl();
//        $data = $curl->PostCurl($getOrderUrl, $orderData);
//        return $data;
//    }

    function dealbaoGetGoodsInfo($keyword=[]){
        $keyword['language_id'] = $this->language->getLanguageId();
        $res = $this->Client->Goods->getGoodsBySpu($keyword);

        if($res['code']==1000012 ){
         $this->dealbaoNewAccessToken();

          $this->dealbaoGetGoodsInfo($keyword);

        }
        return $res;
    }

    function dealbaoGetCollectCategory($keyword=[]){



        $data = $this->Client->Collect->getCollectGroup($keyword);

        if($data['code']==1000012 ){
            $this->dealbaoNewAccessToken();

            $this->dealbaoGetCollectCategory($keyword);

        }
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