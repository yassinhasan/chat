<?php
namespace System;
class Route 
{
    private $app;
    private $routes = [];
    private $current_route;
    private $calls = [];
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    // we need url 
    // then i will add all routes that i need it to get from it
    // controller and action and pattern

    // it will be like that
    // www.chat.com this is url 

    // i need pattern from this url 
    // it will be from url that i write by me self
     
    // like add_route("/","Home")
    // i will get first args as "/user" it will said replace any 
    // [a-zA-Z-0-9 -] and secind by :id 
    // then i will check match between request uri with this pattern
    // if matches i will take controler and action from this route

    public function addRoute($url , $action , $method = "Post")
    {
        $routes = [
            "url"    => $url,
            "pattern" => $this->getPattern($url),
            "action" =>  $this->getAction($action),
            "method" => $method
        ];

        $this->routes[] = $routes;
        
    }

    public function getRoutes()
    {
        return $this->routes;
    }

    public function getPattern($url)
    {

        $pattern ="#^";
        $pattern .= str_replace([":name",":id"],["([a-zA-Z-0-9-]+)","([0-9]+)"],$url);
        $pattern .="$#";
        return $pattern;   

    }
    public function getAction($action)
    {
        if(! strpos($action,"@") !== false)
        {
            $action = $action."@"."index";
            
        }return $action;
    }
     
    public function prepareRoute()
    {
        $allroutes  = $this->getRoutes();

        foreach($allroutes as $route)
        {
            if($this->ismatch($route['pattern']))
            {
               $args = $this->prepareArgs($route['pattern']);
               $this->current_route  =  $route['url'];
               list($controller,$action) = explode("@",$route['action']);
               return [$controller,$action,$args];
            }
            else
            {
                // header("location: login.php");
            }
        }
    }

    public function ismatch($pattern)
    {
        return preg_match($pattern,$this->app->request->url());
    }
    
    public function prepareArgs($pattern)
    {
        preg_match_all($pattern,$this->app->request->url(),$matches);
        array_shift($matches);

        if(!empty($matches)){
             return  $matches[0];
        }

    
    }

    public function getCurrentRoute()
    {
        return $this->current_route;
    }

    // first add function here in this call[] array
    public function callFirst(callable $call)
    {
        $this->calls[] = $call;
    }

    public function emptyCalls()
    {
        return empty($this->calls);
    }

    public function callAllFunctionsFirst()
    {
        // if not empty this->call[]  this means there is function here
        // so please make now this function 
        
        if(! $this->emptyCalls())
        {
            foreach($this->calls as $call)
            {
              return  \call_user_func($call,$this->app);
            }
        }
    }
}