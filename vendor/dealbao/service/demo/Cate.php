<?php
require_once '../vendor/autoload.php';
#use Dealbao\Open\Client as RequestClient;#
//the package management without composer
// require_once '/path/to/deal-open-sdk/../vendor/autoload.php';

//Instantiate the caller
$config["access_token"] = 'your access_token';
$Client = new Dealbao\Open\Client($config);

//get goods cate
$param = [];
$param['language_id'] = 2;
$res = $Client->Cate->getGoodsCategory($param);
var_dump($res);die;








