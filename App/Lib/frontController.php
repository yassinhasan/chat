<?php
namespace App\Lib;

use App\Models\UsersgroupsprivilegesModel;

class frontController 
{
    use redirect;
    const EXCEPTION = [
        "changelang" ,
        "home"      , 
        'access'    ,
        "logout"    ,
        "login"
    ];
    private $contrller = "home";
    private $action = "default" ;
    private $params = array();
    const NOT_FOUND_CONTROLELR  = "App\\Controllers\\NotFoundController";
    const NOT_FOUND_ACTION  = "notfound";
    private $register;
    private $fullClassName;

    public function __construct()
    {
     
        $this->register = register::getInstance();
    }
    public function __get($name)
    {
        return $this->register->$name;
    }
    public function parse_url()
    {
        $reqest_uri = isset($_SERVER['REQUEST_URI']) ?$_SERVER['REQUEST_URI'] : null;
        $reqest_uri = preg_replace("/^\/[a-z]+\//","/",$reqest_uri);
        $url = trim(parse_url($reqest_uri, PHP_URL_PATH),"/");

        $url = explode("/",$url,3);
        if(isset($url[0]) AND $url[0] !== "")
        {
            $this->contrller = $url[0];
        }
        if(isset($url[1]) AND $url[1] !== "")
        {
            $this->action = $url[1];
            
        }
        if(isset($url[2]) AND !empty($url[2]))
        {
            $this->params = explode("/",$url[2]);
        }
        $this->setClassName($this->contrller);
      

    }
    public function setClassName($controller)
    {
         $this->fullClassName = "App\\Controllers\\".ucfirst($controller)."Controller";
    }
    public function getClassName()
    {
       
        return $this->fullClassName;
    }
    public function dispatch()
    {
        $this->parse_url();
        //if not authorized
        if(!$this->auth->isAutherised() AND !in_array($this->contrller,SELF::EXCEPTION))
        {  
                $this->contrller = "Login";
                $this->setClassName($this->contrller);                
        }
        // if authorized but have not access
        $user = $this->profile->getUser();
        if($user != false)
        {
            $user = $this->profile->getUser();
            $allowedPrivileges = $this->profile->getPrivileges();
            $userPrivileges = $this->contrller."/".$this->action;
            if(!in_array($userPrivileges ,  $allowedPrivileges) and !in_array($this->contrller , self::EXCEPTION))
            {
                $this->setClassName("access");
               $this->contrller = "Access";
               $this->action = "default";
            }
        }
        // set control and action if authorized and have access
        if($_SERVER["REQUEST_METHOD"] !== "POST") {
            $this->profile->isNotactive();
       } 
        $fullClassName = $this->getClassName();
        if(!class_exists($fullClassName))
        {
           $fullClassName = self::NOT_FOUND_CONTROLELR ;
           $this->contrller = "NotFound";
         
        }
        $contrller = new $fullClassName();
        if(!method_exists($contrller , $this->action))
        {
           $this->action = self::NOT_FOUND_ACTION;
        }

        $contrller->setController($this->contrller);
        $contrller->setAction($this->action);
        $contrller->setParams($this->params); 
        $contrller->setRegister($this->register); 
        $this->register->setApp($contrller);
       
        $contrller->{$this->action}();
   
    }
    public function run()
    {   
        ini_set('upload_max_filesize', '25M');
        date_default_timezone_set("Asia/Riyadh");
        $this->session->start();
        if(! $this->session->default_lang)
        {
            $this->session->default_lang = DEFAULT_LANG;
        }
        require 'vendor/autoload.php';
        $this->dispatch();
    }

    
}