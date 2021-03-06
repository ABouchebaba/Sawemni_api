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

        return $this->addRoute($path, $callable, "GET");
    }

    public function post($path, $callable ){

        return $this->addRoute($path, $callable, "POST");
    }

    public function put($path, $callable)
    {
        return $this->addRoute($path, $callable, "PUT");
    }

    public function del($path, $callable)
    {
        return $this->addRoute($path, $callable, "DELETE");
    }

    public function addRoute($path, $callable, $methode){
        $route = new Route($path, $callable);
        $this->routes[$methode][] = $route;
        return $route;
    }

    public function run()
    {
        $method = $_SERVER["REQUEST_METHOD"];

        if (!isset($this->routes[$method])){
            // Only GET, POST, PUT, DELETE are supported
            throw new RouteException("Request type not supported");
        }
        foreach ($this->routes[$method] as $route){
            if ($route->matches($this->url)){
                return $route->call();
            }
        }

        // No matching routes => Error message
        throw new RouteException("No matching routes");
    }



}