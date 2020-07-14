<?php

namespace Dealbao\Open\lib\goods;

use Dealbao\Open\core\Api;

class Collect extends Api
{
    /**get collected group list
     * @param array $params
     * @return bool|string
     */
    public function getCollectGroup(array $params)
    {
        return $res = $this->request('Collect/getCollectGroup', $params, 'GET');
    }

    /**
     * get collect goods by group
     * @param array $param
     * @return bool|string
     */
    public function getCollectGoodsByGroup(array $param)
    {
        return $res = $this->request('Collect/getCollectGoodsByGroup', $param, 'POST');
    }

}