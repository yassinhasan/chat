<?php 
namespace System;
use Http\Upload;
class Validator
{
    private $app;
    private $error = [];
    public function __construct(Application $app)
    {
        $this->app = $app;
    }
    public function require($input,$message = null)
    {
        $inputvalue = $this->getValue($input);
        if($inputvalue === "")
        {
            $message = $message !== null ? $message : sprintf("sorry  %s is required",$input);
            $this->message($message);
        }
        return $this;
    }
    public function email($input,$message = null)
    {
        $inputvalue = $this->getValue($input);   
        if(! $inputvalue == "")
        {
            if(! filter_var($inputvalue,FILTER_VALIDATE_EMAIL))
            {
                $message = $message !== null ? $message : sprintf("sorry  %s is not valid email",$input);
                $this->message($message);
            } 
        }

        return $this;
    }
    
    public function getValue($input)
    {
        return $this->app->request->post($input);
    }

    public function message($message = null)
    {
      return  $this->error[] = $message;
    }
    public function valid()
    {
        return empty($this->error);
    }
    public function getErrorMessages()
    {
        return implode("<br>",$this->error);
    }
    public function image($input,$message= null)
    {
         
        $image = $this->app->upload->file($input);
        if(!$image->noError())
        {
            foreach($image->getEroors() as $err)
            {
                $message = $message !== null ? $message : $err;
                $this->message($message); 
            }

        }
        return $this;    
    }

    public function exists($input,$table ,$message = null)
    {
        // select email from users where email = figo78a@gmail.com
        $inputvalue = $this->getValue($input);
        $result = $this->app->db->select($input)->from($table)->where([$input => $inputvalue])->fetch();
        if($result != null)
        {
            $message = $message !== null ? $message : sprintf("sorry  %s is exists ",$input);
            $this->message($message);
        }
        
        
        return $this;
    }

}