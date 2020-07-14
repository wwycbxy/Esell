<?php
namespace Dealbao\Open\lib\serviceprovider;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Dealbao\Open\lib\order\Order;
class OrderServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {

        $pimple['Order'] = function ($pimple) {
            return new Order($pimple->getConfig('access_token'));
        };
    }
}