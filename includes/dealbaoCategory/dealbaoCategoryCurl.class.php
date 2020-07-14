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
class dealbaoCategoryCurl
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