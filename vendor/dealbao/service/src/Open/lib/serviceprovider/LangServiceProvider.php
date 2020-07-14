<?php
namespace Dealbao\Open\lib\serviceprovider;
use Dealbao\Open\lib\basic\Lang;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
class LangServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['Lang'] = function ($pimple) {
            return new Lang($pimple->getconfig('access_token'));
        };
    }
}