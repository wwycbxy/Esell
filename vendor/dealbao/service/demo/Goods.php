<?php
require_once '../vendor/autoload.php';
#use Dealbao\Open\Client as RequestClient;
//the package management without composer
// require_once '/path/to/deal-open-sdk/../vendor/autoload.php';

//Instantiate the caller
$config["access_token"] = '36B6E53FA87D611E90D8BD17BD6CE1AB';
$Client = new Dealbao\Open\Client($config);

//get goods list by cate
$param = [];
$param['gc_id'] = 3;
$param['level'] = 3;
$param['language_id'] = 2;
$res = $Client->Goods->getGoodsListByCate($param);
var_dump($res);

//search goods list
$param = [];
$param['goods_name'] = '诺基亚';
$res = $Client->Goods->searchGoods($param);
var_dump($res);

//get sku stock
$param = [];
$param['sku'] = '402f89fc460003';
$res = $Client->Goods->getGoodsSkuStock($param);
var_dump($res);

//get spu stock
$param = [];
$param['spu'] = '402f89fc46';
$res = $Client->Goods->getGoodsSpuStock($param);
var_dump($res);

//batch get sku stock
$param = [];
$param['skus'] = '402f89fc460003,f507d215020004';
$res = $Client->Goods->batchGetGoodsSKuStock($param);
var_dump($res);

//Check whether the stock of the product supports purchase
$param = [];
$param['skus'] = ['402f89fc460003'=>1000,'f507d215020004'=>930];
$res = $Client->Goods->batchCheckStock($param);
var_dump($res);

//get goods detail by sku
$param = [];
$param['sku'] = '402f89fc46';
$param['language_id'] = 1;
$res = $Client->Goods->getGoodsBySku($param);
var_dump($res);

//get goods detal by sku_language
$param = [];
$param['sku_language'] = '402f89fc460001_2';
$res = $Client->Goods->getGoodsBySkuLanguage($param);
var_dump($res);








