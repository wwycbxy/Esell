<?php

namespace Dealbao\Open\lib\goods;

use Dealbao\Open\core\Api;

class Goods extends Api
{
    /**get simple goods list by cate
     * @param array $params
     * @return bool|string
     */
    public function getGoodsListByCate(array $params = [])
    {
        return $res = $this->request('Goods/getGoodsListByCate', $params, 'GET');
    }

    /**search goods list
     * @param array $params
     */
    public function searchGoods(array $params)
    {
        return $res = $this->request('Goods/searchGoods', $params, 'GET');
    }

    /**
     * search goods list
     * @param array $params
     * @return bool|string
     */
    public function getGoodsListByCateGroup(array $params)
    {
        return $res = $this->request('Goods/getGoodsListByCateGroup', $params, 'GET');
    }

    /**get sku stock
     * @param array $params
     * @return bool|string
     */
    public function getGoodsSkuStock(array $params = [])
    {
        return $res = $this->request('Goods/getGoodsSkuStock', $params, 'GET');
    }

    /**batch get sku stock
     * @param array $params
     * @return bool|string
     */
    public function batchGetGoodsSKuStock(array $params = [])
    {
        return $res = $this->request('Goods/batchGetGoodsSKuStock', $params, 'GET');
    }

    /**check sku stock
     * @param array $params
     * @return bool|string
     */
    public function batchCheckStock(array $params = [])
    {
        return $res = $this->request('Goods/batchCheckStock', $params, 'GET');
    }

    /**search spu stock
     * @param array $params
     */
    public function getGoodsSpuStock(array $params)
    {
        return $res = $this->request('Goods/getGoodsSpuStock', $params, 'GET');
    }

    /**
     * get goods detail by sku
     */
    public function getGoodsBySku(array $params)
    {
        return $res = $this->request('Goods/getGoodsBySku', $params, 'GET');
    }

    /**
     * get goods detail by sku
     */
    public function getGoodsBySpu(array $params)
    {
        return $res = $this->request('Goods/getGoodsBySpu', $params, 'GET');
    }

    /**get goods detal by sku_language
     * @param array $params
     */
    public function getGoodsBySkuLanguage(array $params)
    {
        return $res = $this->request('Goods/getGoodsBySkuLanguage', $params, 'GET');
    }
}