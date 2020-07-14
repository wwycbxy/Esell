<?php
require_once '../vendor/autoload.php';
#use Dealbao\Open\Client as RequestClient;#
//the package management without composer
// require_once '/path/to/deal-open-sdk/../vendor/autoload.php';

//fill in the public parameters,if filled, will overwrite config.php
$config['appid'] = 'your appid';
$config['secret'] = 'your secret';

//Instantiate the caller
$Client = new Dealbao\Open\Client($config);

//get access_token without refresh_token
$res = $Client->AccessToken->getAccessToken();
var_dump($res);

//get access_token with refresh_token
$param['refresh'] = true;
$res = $Client->AccessToken->getAccessToken($param);
var_dump($res);

//refactor access_tokne with refresh_token
$refresh_token = "your refresh_token";
$res = $Client->AccessToken->refreshAccessToken($refresh_token);
var_dump($res);




