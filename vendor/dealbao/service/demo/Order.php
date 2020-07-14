<?php
require_once '../vendor/autoload.php';
#use Dealbao\Open\Client as RequestClient;#
//the package management without composer
// require_once '/path/to/deal-open-sdk/../vendor/autoload.php';

//Instantiate the caller
$config["access_token"] = 'your access_token';
$Client = new Dealbao\Open\Client($config);

//get order list
$param['page'] = 1;
$param['size'] = 1;
$param['sort'] = ["order_sn"=>["order"=>"desc"]];
$param['goods_name'] = '诺基亚';
$param['order_state'] = 'wait_pay';
$param['order_sn'] = '209117455110020';
$param['buyer_name'] = '18166334886';
$param['shipping_code'] = '';
$param['buyer_phone'] = '18166334886';
$param['payment_code'] = 'online';
$param['goods_sku'] = '402f89fc460003';
$param['create_time'] = ['start_time'=>1591174551,'end_time'=>1591174551];
$res = $Client->Order->getOrderList($param);
var_dump($res);die;

//create application order
$param = [];
$time_stamp = time();
$nonce = md5($time_stamp);
$param['time_stamp'] = $time_stamp;
$param['nonce'] = $time_stamp;#不重复随机字符串
$param['items'] = json_encode(['402f89fc460003_2'=>4,'402f89fc460001_1'=>6,'f507d215020004_6'=>3,'f507d215020004_1'=>7]);
$param['order_source'] = "app";
$param['mapping_area'] = ['country_id'=>1,'province_id'=>22,'city_id'=>62,'area_id'=>356];
$param['area_info'] = "中华人民共和国 四川省 邻水县 丰禾镇";
$param['address'] = "兴明村12对";
$param['true_name'] = "王权";
$param['mob_phone'] = "1888888888";
$param['order_message'] = ['28'=>"备注信息",'30'=>"备注信息"];
$res = $Client->Order->createAppOrder($param);
var_dump($res);






