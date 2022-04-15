<?php
namespace App\Lib;


use SessionHandler;


class myCustomSessionHandler extends  SessionHandler
{
    use encryptDecrypt;
    use redirect;

    const PATH = "/";
    const LIFETIME = 10000000;
    const HTPPSECURED = true;
    const HTTPONLY = true;
    const SESSIONAME = 'chat';
    
    public function __construct()
    {
        session_name(self::SESSIONAME);
        ini_set("session.use_cookies", 1);
        ini_set("session.use_only_cookies" , 1);
        ini_set("session.use_trans_sid" , 0);
        ini_set("session.save_handler", "files");
        session_set_save_handler($this,true);
        session_set_cookie_params(

            self::LIFETIME,
            self::PATH,
            $_SERVER['HTTP_HOST'],
            self::HTPPSECURED,
            self::HTTPONLY
        );

    }

    public function start()
    {
        if(session_id() == "")
        {
            
          if(session_start())
          {
            $this->checkValidSession();
           $this->checkFingerPrint();
          }
        }
    }


    public function generateFingerPring()
    {
        $this->fingerprint = hash("sha256",$_SERVER['HTTP_USER_AGENT'].session_id());
    }

    public function checkFingerPrint()
    {
        if(!$this->fingerprint)
        {
            $this->generateFingerPring();
        }
        $fingerprint =  hash("sha256",$_SERVER['HTTP_USER_AGENT'].session_id());
        if($fingerprint != $this->fingerprint)
        {
            $this->kill();
        }
    }
    public function __set($name, $value)
    {
         $_SESSION[$name] = $value;
    }
    public function __get($name)
    {
       if(array_key_exists($name,$_SESSION))
       {
         return   $_SESSION[$name];
         
       }else
       {
           return false;
       }
    }

    public function has($key)
    {
        return array_key_exists($key,$_SESSION);
    }

    public function pull($key)
    {
        $data = $_SESSION[$key];
      
        return $data;
    }

    public function getAll()
    {

        pre($_SESSION);
    }
    public function __unset($name)
    {
        
        if(array_key_exists($name , $_SESSION))
        {
            unset($_SESSION[$name]);
        }
   
    }
    public function __isset($name)
    {
        return array_key_exists($name,$_SESSION);
    }
    public function setSessionTimer()
    {
        if(! $this->lifetime)
        {
            $this->lifetime = time();
            
        }
        
    }

    public function checkValidSession()
    {
        $this->setSessionTimer();
        if(time() - $this->lifetime > (self::LIFETIME * 60))
        {
            $this->lifetime = time();
            $this->generateFingerPring();
            session_regenerate_id(true);
        }
    }

    public function kill()
    {
        session_unset();
        session_destroy();
        setcookie(self::SESSIONAME,"",self::LIFETIME * -100 , "/",$_SERVER['HTTP_HOST'],true,true);
    }
 
    public function write( $id,  $data): bool
    {
        $data = $this->encrypt($data);
        
       if(  parent::write($id, $data))
       {
           return true;
       }
    }


    public function read($id): string
    {
        $data  = parent::read($id);

        if(!$data)
        {
            return "";
        }else 
        {
            return $this->decrypt($data);
        }
    }


    
}