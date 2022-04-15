<?php
namespace App\Lib;

class cookie 
{
    const SESSIONAME = "cms";
    const PATH = "/";
    const LIFETIME = " +1 hour";
    const HTPPSECURED = true;
    const HTTPONLY = true;
    

    public function setCookie($key,$value , $time = 1)
    {

        $time = $time == -1 ? $time :  strtotime(self::LIFETIME );
        setcookie($key , $value ,  $time ,self::PATH ,  $_SERVER['HTTP_HOST'] , self::HTPPSECURED , self::HTTPONLY);  
    }


    public function has($key)
    {
        return array_key_exists($key,$_COOKIE);
    }

    public function get($key)
    {
      
        
        if(array_key_exists($key , $_COOKIE))
        {
           
            return $_COOKIE[$key];
        }else
        {
            
            echo "soory this $key is not found in cookie";
        }

    }

    public function getAll()
    {

        pre($_COOKIE);
    }
    public function unset($name)
    {
        
        if(array_key_exists($name , $_COOKIE))
        {
            unset($_COOKIE[$name]);
        }
   
    }
    public function kill($key)
    {
        $this->setCookie($key , null , -1);
        $this->unset($key);
    }
 





    
}