<?php
namespace Dealbao\Open;

use Dealbao\Open\base\Base;

/**
 * client class
 */
class Client extends Base{

    protected $providers = [
        lib\serviceprovider\AccessTokenServiceProvider::class,
        lib\serviceprovider\OrderServiceProvider::class,
        lib\serviceprovider\LangServiceProvider::class,
        lib\serviceprovider\CateServiceProvider::class,
        lib\serviceprovider\AreaServiceProvider::class,
        lib\serviceprovider\GoodsServiceProvider::class,
        lib\serviceprovider\CollectServiceProvider::class
    ];
}