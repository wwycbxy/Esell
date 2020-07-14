<?php
namespace Dealbao\Open\lib\serviceprovider;
use Dealbao\Open\lib\basic\Area;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
class AreaServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['Area'] = function ($pimple) {
            return new Area($pimple->getConfig('access_token'));
        };
    }
}