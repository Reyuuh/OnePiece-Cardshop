<?php

require_once("Utils/router.php"); 
require_once("vendor/autoload.php"); 


$dotenv = Dotenv\Dotenv::createImmutable("."); 
$dotenv->load();

class Router
{
private $routes = [];
public function addRoute($route, $function)
{
    $this->routes[$route] = $function;
}
public function dispatch()
{
    $url = $_SERVER['REQUEST_URI'] ??'/';
    $n = strpos($url,'?');
    if ($n) {
        $url = substr($url,0, strpos($url,'?'));
    }

    if(isset($this->routes[$url])) {
        call_user_func($this->routes[$url], $url);
    } else {
        http_response_code(404);
        echo'Page not found';
    }
  }
}
?>