<?php
namespace Dealbao\Open\base;

use Pimple\Container;
use Dealbao\Open\Config;

/**
 * Class Foundation
 * @property-read Http $http
 * @package Hanson\Foundation
 */
class Base extends Container
{

    /**
     * an array of service providers.
     *
     * @var
     */
    protected $providers = [];

    protected $config;

    public function __construct(array $config = [])
    {

        parent::__construct();

        $this->setConfig($config);

        $this->registerProviders();

    }
    /**
     * Register providers.
     */
    protected function registerProviders()
    {
        foreach ($this->providers as $provider) {

            $this->register(new $provider());

        }
    }

    public function setConfig(array $config)
    {
        empty($config['appid']) && $config['appid'] = Config::APPID;

        empty($config['secret']) && $config['secret'] = Config::SECRET;
        
        $this->config = $config;
    }

    public function getConfig($key = null)
    {
        return $key ? ($this->config[$key] ?? null) : $this->config;
    }

    /**
     * Magic get access.
     *
     * @param  string  $id
     *
     * @return mixed
     */
    public function __get($propertyKey)
    {
        return $this->offsetGet($propertyKey);
    }

    /**
     * Magic set access.
     *
     * @param  string  $id
     * @param  mixed  $value
     */
    public function __set($propertyKey, $value)
    {
        $this->offsetSet($propertyKey, $value);
    }
}
