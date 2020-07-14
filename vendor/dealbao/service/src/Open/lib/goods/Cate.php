<?php
namespace Dealbao\Open\lib\goods;
use Dealbao\Open\core\Api;
class Cate extends Api
{
    /**get goods list by cate
     * @param array $params
     * @return bool|string
     */
    public function getGoodsCategory(array $params){
        return $res = $this->request('Category/categoryList',$params,'GET');
    }

}