<?php


namespace App\Router;


class Router {

    private $url;

    /** @var  Route[] */
    private $routes = [];

    /** @var string[]  */
    private $namedRoutes = [];

    /**
     * Router constructor.
     * @param $url
     */
    public function __construct($url) {
        $this->url = $url;
    }

    /**
     * Route en Get
     * @param $path
     * @param $callable
     * @param null $name
     * @return Route
     */
    public function get(string $path, $callable, $name = null):Route{
        return $this->add($path, $callable, $name, 'GET');
    }


    public function post(string $path, $callable, $name = null):Route{
        return $this->add($path, $callable, $name, 'POST');
    }

    private function add(string $path, $callable, $name, $method):Route{
        $route = new Route($path, $callable);
        $this->routes[$method][] = $route;
        if($name){
            $this->namedRoutes[$name] = $route;
        }
        return $route;
    }


    public function run(){
        if(!isset($this->routes[$_SERVER['REQUEST_METHOD']])){
            throw new RouterException('REQUEST_METHOD does not exist', 404);
        }
        foreach($this->routes[$_SERVER['REQUEST_METHOD']] as $route){
            if($route->match($this->url)){
                return $route->call();
            }
        }
        throw new RouterException('No routes matches', 404);
    }

    public function url($name, $params = []){
        if(!isset($this->namedRoutes[$name])){
            throw new RouterException('No route matches this name', 404);
        }
        return $this->namedRoutes[$name]->getUrl($params);
    }


}