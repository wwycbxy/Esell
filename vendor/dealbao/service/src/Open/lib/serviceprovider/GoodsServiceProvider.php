<?php
namespace Dealbao\Open\lib\serviceprovider;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Dealbao\Open\lib\goods\Goods;
class GoodsServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {

        $pimple['Goods'] = function ($pimple) {
            return new Goods($pimple->getConfig('access_token'));
        };
    }
}