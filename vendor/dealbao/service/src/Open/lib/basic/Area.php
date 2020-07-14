<?php
namespace Dealbao\Open\lib\basic;
use Dealbao\Open\core\Api;
class Area extends Api
{
    /**get all area list
     * @param array $params
     * @return bool|string
     */
    public function getAllAreaList(array $params = []){
        return $res = $this->request('Area/getAllAreaList',$params,'GET');
    }


}