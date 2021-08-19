<?php 
namespace System;
class Load 
{
    private $app;
    private $controlelr;
    public function __construct(Application $app)
    {
        $this->app= $app;
    }

    // now we have Home so we need to add to it HomeController
    // then add prefix "App\Controllers"
    // then load function index of it with their args
     
    public function load($controlelr,$action,$args = null)
    {
        $controlelr = "App\\Controllers\\".$controlelr."Controller";
        $controlelr = new $controlelr($this->app);
        if($args == null)
        {
            $args = [];
        }
    //    return $controlelr->$action();
    return call_user_func_array(array($controlelr, $action), $args);
    }

    public function controller($controlelr)
    {
        $controlelr = "App\\Controllers\\".ucfirst($controlelr)."Controller";
        $controlelr = new $controlelr($this->app);
        return $controlelr;
    }
    // public function loadModel($controlelr,$action,$args = [])
    // {
    //     $controlelr = "App\\Controllers\\".$controlelr."Controller";
    //     $controlelr = new $controlelr($this->app);

    // //    return $controlelr->$action();
    // return call_user_func_array(array($controlelr, $action), $args=[]);
    // }

    public function model($model)
    {
        $model = "App\\Models\\".ucfirst($model)."Model";
        $model = new $model($this->app);
        return $model;
    }
}