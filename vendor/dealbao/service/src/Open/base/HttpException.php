<?php
namespace Dealbao\Open\base;
/**
 * exception class
 */
class HttpException extends \Exception
{
    public function errorMessage()
    {
        return $this->getMessage();
    }
}