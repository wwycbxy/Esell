<?php
require_once '../vendor/autoload.php';
#use Dealbao\Open\Client as RequestClient;#
//the package management without composer
// require_once '/path/to/deal-open-sdk/../vendor/autoload.php';

//Instantiate the caller
$config["access_token"] = 'D455F71BDF68AAA805795FF5A255B400';
$Client = new Dealbao\Open\Client($config);

//get area list
$param = [];
$param['language_id'] = 2;
$res = $Client->Area->getAllAreaList($param);
var_dump($res);










