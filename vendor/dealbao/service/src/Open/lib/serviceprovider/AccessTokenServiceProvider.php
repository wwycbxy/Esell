<?php
namespace Dealbao\Open\lib\serviceprovider;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Dealbao\Open\lib\token\AccessToken;
class AccessTokenServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['AccessToken'] = function ($pimple) {
            return new AccessToken($pimple->getconfig('appid'),$pimple->getconfig('secret'));
        };
    }
}