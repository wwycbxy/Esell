<?php

namespace Dealbao\Open\lib\serviceprovider;

use Dealbao\Open\lib\goods\Collect;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class CollectServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['Collect'] = function ($pimple) {
            return new Collect($pimple->getConfig('access_token'));
        };
    }
}