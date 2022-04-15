<?php
namespace App\Lib;
class register 
{
    private static $instance ;

    private $container= [];
    private $app;
    private function __construct(){}
    private function __clone(){}
    public static function getInstance()
    {
        if(self::$instance == null)
        {
            self::$instance = new self();
        }
        return self::$instance;
    }



    public function allClass()
    {
        return [
            "session" => "App\Lib\myCustomSessionHandler",
            "messenger" => "App\Lib\messenger",
            "lang"      => "App\Lib\lang",
            "template"      => "App\Lib\\template",
            "auth"          => "App\Lib\authentication",
            "profile"          => "App\Lib\profile",
            "cookie"          => "App\Lib\cookie",
            "emailMsg"          => "App\Lib\\emailMessage",
            "templatehelper"          => "App\Lib\\templateHelper",
            "uploadfile"        => "App\Lib\uploadFile",
        ];
    }

    public function createObject($class)
    {

        $allObject = $this->allClass();
        $obj  = $allObject[$class];
        $newobj = new $obj($this);
        return $newobj;

    }

    public function checkClassExists($class)
    {
        
        return in_array($class,array_keys($this->allClass())) ;
    }

    public function addInContainer($key , $value)
    {

        $this->container[$key] =  $value ;

    }

    public function isInContainer($key)
    {
        if(!empty($this->container))
        {
            return in_array($key,array_keys($this->container)) ;
        }else
        {
            return false;
        }
    }

    // $this->register == register::gitinstance

    public function getObject($key)
    {
            // scenario check if in classes or not
            if(!$this->checkClassExists($key))
            {  
                
                echo "sorry this class $key is not found";
            }else if(!$this->isInContainer($key))
            {
                $this->addInContainer($key,$this->createObject($key)); 
                  
            }   return $this->container[$key];               

    }
    public function __get($name)
    {
       if($name === "app")
       {
           return $this->getApp();
       } 
       return $this->getObject($name);
    }

    public function setApp($app)
    {
        $this->app = $app;
    }
    public function getApp()
    {
        return $this->app;
    }
    
}