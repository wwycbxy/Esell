<?php
namespace Dealbao\Open\core;

class RequestUrl
{

    const FORMAT_USER_AGENT = 'Dealbao-Open-Client %s-PHP';

    const REQUEST_BASE_URL = 'http://api.tserv.dealbao.cn/';


    const REQUEST_PATH_TOKEN = 'Oauth/getAccessToken';

    //const REQUEST_PATH_REFRESH = 'Oauth/refreshAccessToken';


    public static function buildRequestUrl($path)
    {

        return self::REQUEST_BASE_URL. $path;

    }

    public static function buildAccessTokenUrl()
    {
        return self::REQUEST_BASE_URL. self::REQUEST_PATH_TOKEN;
    }

   /* public static function buildrefreshTokenUrl()
    {
        return self::REQUEST_BASE_URL. self::REQUEST_PATH_REFRESH;
    }*/


    public static function buildHttpHeaders()
    {
        return [
            'User-Agent' => sprintf(self::FORMAT_USER_AGENT),
        ];
    }
}