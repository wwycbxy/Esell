## dealbao-open-sdk  Instructions 

english document | [中文说明](README_CN.md)

## 一、download：

​		composer url：https://packagist.org/packages/dealbao/service

​		composer command：composer require dealbao/service 

​		github url：https://github.com/wangfuguier2009/dealbao

## 二、How to use：

​		If your framework has automatic loading, use it directly

​		If the framework cannot automatically load ,then use require_once'../vendor/autoload.php' in your php file; #The path is your own path

## 三、fill config:

​		Find the configuration file config.php, fill in your appid and secret

### 四、Client instantiation (refer to demo for details)

##### 		1.get access_token

```
#use Dealbao\Open\Client as RequestClient;
// require_once '/path/to/deal-open-sdk/../vendor/autoload.php';

//Instantiate the caller
$Client = new Dealbao\Open\Client();
```

​	 There is another way to not use configuration files，pass appid and secret to instantiate

```
$config['appid'] = 'your appid';
$config['secret'] = 'your secret';
//Instantiate the caller
$Client = new Dealbao\Open\Client($config);
```



##### 		2.Client instance when requesting another interface

​			pass in access_token

```
//Instantiate the caller
$config["access_token"] = '36B6E53FA87D611E90D8BD17BD6CE1AB';
$Client = new Dealbao\Open\Client($config);
```

### 

## 五、Request example（refer to demo for details）

#### 		1.Get a list of languages

```
//Instantiate the caller
$config["access_token"] = '72A3B9F45EE104C960E7086472A7ADD2';
$Client = new Dealbao\Open\Client($config);

//get  support language
$res = $Client->Lang->getLangList();
var_dump($res);
	
```

#### 		2.Obtain the product list according to the classification (where the parameters are based on the official website: the parameters specified in the interface) 

```
$param = [];
$param['gc_id'] = 3;
$param['level'] = 3;
$param['language_id'] = 2;
$res = $Client->Goods->getGoodsListByCate($param);
```