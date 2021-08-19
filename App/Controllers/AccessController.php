<?php
namespace App\Controllers;
use System\Application;
class AccessController 
{
    private $app;
    public function __construct(Application $app)
    {
        $this->app = $app;
    }
    public function index()
    {
        $exception_url = [
            "/signup","/login"
        ];



        $current_url = $this->app->route->getCurrentRoute();
        if(!$this->app->session->has("logincode") and !in_array($current_url, $exception_url))
        {
            
        //  header("location: /signup");
         
        }
    }


}