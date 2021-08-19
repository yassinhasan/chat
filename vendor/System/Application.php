<?php
namespace System;

use Closure;

class Application 
{

    public static $instance;
    public $file;
    public $name;
    public  $container = [];
    
    public function __construct(File $file)
    {
        $this->file = $file;
        $this->loadHelperFile();
        self::$instance = $this;
        $this->autoLoadFunction();
    }


    public function __get($name)
    {

        return $this->get($name);
    }

    public function get($name)
    {

        // if not found in contaner 
       if(!$this->isFoundKey($name))
       {
           if($this->isCoreClasses($name))
           {
            
            $allcoreclasses = $this->allCoreClasses();
            $obj = $allcoreclasses[$name];
            $this->addInContainer($name,new $obj($this));
            return $this->container[$name];
            }else
            {
                echo "soory this $name not found";
            }
       }
       // found in container so return it
       else
       {
           return $this->container[$name];
       }
    }

    // $this->session  == if not found in container 
        // if not corealias so it's not class 
        // else add in container this key and i;ts value = object
    // else mean found in container so return this->container
    public function addInContainer($key,$value)
    {
        if($value instanceof Closure)
        {
            // what i need 
            //  i need when i write $this->app->layout
            // return function of this layout
            // how to do this
            $value = \call_user_func($value,$this);
        }
        $this->container[$key] = $value;   
        

    }

    public function isFoundKey($name)
    {
        return array_key_exists($name,$this->container);
    }




    // start we wtite app->session 
    // so it start so search in container 
    // if found return it's object 
    // if not found show error no class of this name

    public function allCoreClasses()
    {
        $allclasses =  [
            "session" => "System\\Session",
            "db"      => "System\\DataBase",
            "route"   =>  "System\\Route",
            "load"    =>  "System\\Load",
            "request" =>  "Http\\Request",
            "view"    =>  "Http\\View",
            "html"    =>  "Http\\Html",
            "upload"  =>  "Http\\Upload",
            "cookie"  => "System\\Cookie",
            "validator"  => "System\\Validator"
 
        ];
        return $allclasses;
    }

    public function isCoreClasses($key)
    {
        return array_key_exists($key,$this->allCoreClasses());
    }


    
    public static function getinstance($file = null)
    {
        if( self::$instance == null)
        {
            self::$instance = new self($file);
           
        }
   
        return self::$instance;


    }

    public function autoLoadFunction()
    {
      return  spl_autoload_register(array($this,"loadclass"));
    }

    public function loadclass($class)
    {
        if(strpos($class,"App") === 0)
        {
            $file =   $this->file->dir()."\\$class.php";
           if(file_exists($file))
           {
            require $this->file->dir()."\\$class.php";
           }
           else
           {
               header("location: /notfound");
           }
        }
        else
        {
            require $this->file->toVendor()."$class.php";
        }
    }

    public function loadHelperFile()
    {
        $this->file->require("Vendor\System\helper.php");
    }
    public function run()
    {
        $this->session->start();
        $this->request->prepareUrl();
        $this->file->toBase("App/index.php"); 
        list($cotrller,$action,$args) = $this->route->prepareRoute();
        // here if there is function in call[] array so return it;
        $this->route->callAllFunctionsFirst();
        $this->load->load($cotrller,$action,$args);
    }
}