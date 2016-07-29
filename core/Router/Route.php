<?php

namespace App\Router;


class Route {

    private $callable;
    private $path;
    private $matches = [];
    private $params = [];

    public function __construct($path, $callable){
        $this->callable = $callable;
        $this->path = trim($path, '/');
    }

    public function match($url){
        $url = trim($url, '/');
        $path = preg_replace_callback('#:([\w]+)#', [$this, 'paramMatch'], $this->path);
        $regex = "#^$path$#i";
        if(!preg_match($regex, $url, $matches)){
            return false;
        }
        array_shift($matches);
        $this->matches = $matches;
        return true;
    }

    private function paramMatch($match){
        if(isset($this->params[$match[1]])){
            return '('.$this->params[$match[1]].')';
        }
        return '([^/]+)';
    }

    public function call(){
        if(is_string($this->callable)){
            $params = explode("@", $this->callable);
            $controller = "App\\Controller\\". $params[0];
            $controller = new $controller();
            return call_user_func_array([$controller, $params[1]], $this->matches);
        }else{
            return call_user_func_array($this->callable, $this->matches);
        }
    }

    public function with($param, $regex){
        $this->params[$param] = str_replace('(', '(?:', $regex);
        return $this;
    }

    public function getUrl($params){
        $path = $this->path;
        foreach($params as $k => $v){
            $path = str_replace(":$k", $v, $path);
        }
        return $path;
    }
}