<?php
namespace Dealbao\Open\lib\serviceprovider;
use Dealbao\Open\lib\goods\Cate;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
class CateServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['Cate'] = function ($pimple) {
            return new Cate($pimple->getConfig('access_token'));
        };
    }
}