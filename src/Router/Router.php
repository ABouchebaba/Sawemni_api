<?php
/**
 * Created by PhpStorm.
 * User: amine
 * Date: 25/03/2019
 * Time: 16:20
 */

namespace App\Router;


class Router
{

    private $url;
    private $routes = [];

    public function __construct($url){
        $this->url = $url;
    }

    public function get($path, $callable ){

        $this->addRoute($path, $callable, "GET");
    }

    public function post($path, $callable ){

        $this->addRoute($path, $callable, "POST");
    }

    public function put($path, $callable)
    {
        $this->addRoute($path, $callable, "PUT");
    }

    public function del($path, $callable)
    {
        $this->addRoute($path, $callable, "DELETE");
    }

    public function addRoute($path, $callable, $methode){
        $route = new Route($path, $callable);
        $this->routes[$methode][] = $route;
    }

    public function run()
    {
        $method = $_SERVER["REQUEST_METHOD"];

        if (!isset($this->routes[$method])){
            throw new RouteException("Request type not supported");
        }
        foreach ($this->routes[$method] as $route){
            if ($route->matches($this->url)){
                return $route->call();
            }
        }
        throw new RouteException("No matching routes");
    }



}