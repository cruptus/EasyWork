<?php


namespace App\Router;

use App\Config;
use App\Controller\Controller;

class RouterException extends \Exception {

    public function __construct($message, $code = 0, \Exception $previous = null)
    {
        if(Config::$DEBUG)
            parent::__construct($message, $code, $previous);
        else {
            $controler = new Controller();
            $controler->error("$code");
            die();
        }
    }
}