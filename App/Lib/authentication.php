<?php
namespace App\Lib;
use App\Models\UsersModel;

class authentication 
{
    use encryptDecrypt;
    private $register ;
    public function __construct(register $register){
        $this->register = $register;
    }   
    public function isAutherised()
    {
       $loginCode = "" ;
       if($this->cookie->has("loginCode"))
       {
         
            $loginCode = $this->cookie->get("loginCode");
       }else if(isset($this->session->loginCode))
       {

             $loginCode = $this->session->loginCode;
       }

       $userName = $loginCode == "" ? "" : $this->decrypt($loginCode);
       $founduser = UsersModel::geBasicinformation("userName" ,$userName);
       if($founduser !== false)
       {
            $founduser = $founduser[0];
            $this->session->user = $founduser;
        return true;
       }else
       {
       return false;           
       }

    }
    public function __get($name)
    {
        return $this->register->$name;
    }
    public function getUser()
    {
        return $this->session->user;
    }
}