<?php
/**
 * Created by PhpStorm.
 * User: amine
 * Date: 25/03/2019
 * Time: 16:25
 */

namespace App\Router;


class Route
{

    private $path;
    private $callable;
    private $matches = [];
    private $params = [];
    private $middlewares = [];

    public function __construct($path, $callable)
    {
        $this->path = trim($path, "/");
        $this->callable = $callable;
    }

    public function matches($url) {

        $url = trim($url, "/");

        $path = preg_replace_callback('#:([\w]+)#', [$this, "replaceParam"], $this->path);

        $regex = "#^$path$#i";

        if (!preg_match($regex, $url, $matches)){
            return false;
        }

        array_shift($matches);

        $this->matches = $matches;
        return true;
    }
    public function replaceParam($matches){
        if (isset($this->params[$matches[1]])){
            return '('.$this->params[$matches[1]].')';
        }
        return '([^/]+)';
    }

    public function with($param, $regex){

        $this->params[$param] = str_replace('(', "(?:", $regex);
        return $this;
    }

    public function middleware($middlewares){

        //$this->middlewares[] = $middleware;
        foreach ($middlewares as $m){
            $this->middlewares[] = $m;
        }
        return $this;
    }

    public function call(){

        // call middlewares before calling the controller methods
        $pass = $this->callMiddlewares();
        if ($pass !== true) return json_encode($pass);

        // if middlewares passed call controller methods
        if (is_string($this->callable)){

            $params = explode(".", $this->callable);

            $controller = "App\Controller\\". $params[0];
            $controller = new $controller();

            return call_user_func_array([$controller, $params[1]], $this->matches);

        }
        return call_user_func_array($this->callable, $this->matches);
    }

    private function callMiddlewares(){

        foreach ($this->middlewares as $middleware ){
            $params = explode(".", $middleware);

            $controller = "App\Middleware\\". $params[0];
            $controller = new $controller();

            $res =  call_user_func_array([$controller, $params[1]], $this->matches);


            if($res !== true) {
                return $res;
            }

        }
        return true;

    }
}