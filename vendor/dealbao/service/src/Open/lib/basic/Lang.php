<?php
namespace Dealbao\Open\lib\basic;
use Dealbao\Open\core\Api;
class Lang extends Api
{
    public function getLangList(array $params = []){
        return $res = $this->request('Language/getLangList',$params,'GET');
    }
}