## dealbao-open-sdk  Instructions 

[english document](README.md) | 中文说明

## 一、下载：

​		composer地址：https://packagist.org/packages/dealbao/service

​		composer命令：composer require dealbao/service 

​		github地址：https://github.com/wangfuguier2009/dealbao

## 二、使用方法：

​		如果您的框架具有自动加载功能，请直接使用

如果框架无法自动加载，请在您的php文件中使用require_once'../ vendor / autoload.php'; ＃路径是你自己的路径

## 三、填写配置:

​		找到配置文件config.php，并填写您的appid和seret

### 四、客户端实例化（详细请参考demo）

##### 		1.获取access_token

```
#use Dealbao\Open\Client as RequestClient;
// require_once '/path/to/deal-open-sdk/../vendor/autoload.php';

//Instantiate the caller
$Client = new Dealbao\Open\Client();
```

​	 另一种不使用配置文件的方法，直接传递appid和secret去实例化

```
$config['appid'] = 'your appid';
$config['secret'] = 'your secret';
//Instantiate the caller
$Client = new Dealbao\Open\Client($config);
```



##### 		2.请求其他接口时的客户端实例

​			传递access_token

```
//Instantiate the caller
$config["access_token"] = '36B6E53FA87D611E90D8BD17BD6CE1AB';
$Client = new Dealbao\Open\Client($config);
```

### 

## 五、Request example（refer to demo for details）

#### 		1.获取支持的语言列表

```
//Instantiate the caller
$config["access_token"] = '72A3B9F45EE104C960E7086472A7ADD2';
$Client = new Dealbao\Open\Client($config);

//get  support language
$res = $Client->Lang->getLangList();
var_dump($res);
	
```

#### 		2.按分类获取产品清单（参数以官网接口参数为准：）

```
$param = [];
$param['gc_id'] = 3;
$param['level'] = 3;
$param['language_id'] = 2;
$res = $Client->Goods->getGoodsListByCate($param);
```