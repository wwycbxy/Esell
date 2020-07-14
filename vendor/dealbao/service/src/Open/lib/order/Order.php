<?php
namespace Dealbao\Open\lib\order;
use Dealbao\Open\core\Api;
class Order extends Api
{
    public function getOrderList(array $params){
        return $res = $this->request('Order/getOrderList',$params,'GET');
    }
    /**
     * create a new order method
     * @param array $params
     */
    public function createMemberOrder(array $params){
        return $this->request('Order/createMemberOrder',$params,'PUT',true);
    }
    /**
     * create a new order method
     * @param array $params
     */
    public function createAppOrder(array $params){
        return $this->request('Order/createAppOrder',$params,'PUT',true);
    }
}