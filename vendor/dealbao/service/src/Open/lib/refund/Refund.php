<?php
namespace Dealbao\Open\lib\refund;
use Dealbao\Open\core\Api;
class Refund extends Api
{
    public function getOrderList(array $params){
        return $res = $this->request('Order/getOrderList',$params,'GET');
    }
    /**
     * create a new order method
     * @param array $params
     */
    public function createMemberOrder(array $params){
        $this->buildSignature($params);
        return $this->request('Order/createMemberOrder',$params,'PUT');
    }
    /**
     * create a new order method
     * @param array $params
     */
    public function createAppOrder(array $params){
        $this->buildSignature($params);
        return $this->request('Order/createAppOrder',$params,'PUT');
    }
}