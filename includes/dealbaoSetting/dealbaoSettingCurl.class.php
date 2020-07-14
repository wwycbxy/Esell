<?php
/**
 * Created by PhpStorm.
 * User: BXY
 * Date: 2020/5/29
 * Time: 16:02
 */

require_once DEALBAO_PLUGIN_DIR . '/vendor/autoload.php';

class dealbaoSettingCurl
{
    function dealbaoAccessToken($data = []){

        $config['appid'] = $data['appid'];
        $config['secret'] = $data['secret'];
        $Client = new \Dealbao\Open\Client($config);
        $res = $Client->AccessToken->getAccessToken();
        session_start();
        if($res['code']==200){
            $_SESSION['accessToken'] ='';
            $_SESSION['accessToken'] = $res['data']['access_token'];
        }else{
            wp_die(__('Interface Error','dealbao'));
        }
        return $data;

    }


}