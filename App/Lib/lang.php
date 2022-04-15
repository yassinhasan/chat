<?php 
namespace App\Lib;

class lang 
{
    public $dic;
    public function laod($path = null)
    {
        if(strpos($path,"|") == false)
        {
            $file = LANG_PATH.$_SESSION['default_lang'].DS.lcfirst($path).".lang.php";  
        }else
        {   
            $path = explode("|",$path);
            $contrllername = $path[0];
            $actionname = $path[1];
            $file =  LANG_PATH.$_SESSION['default_lang'].DS.lcfirst($contrllername).DS.lcfirst($contrllername).$actionname.".lang.php";               
        }
        if(file_exists($file)){
            $content = require $file;
            $this->setDic($content);
        }else
        {
            echo "soory  $file";
        }
        return $this;
    }

    public function setDic($content)
    {
       if(!empty($this->dic))
       {
           $this->dic = array_merge($this->dic,$content);
       }else
       {
        $this->dic = $content;
       }
       
    }
    public function getDic()
    {
        
        return $this->dic;
    }
    public function getKey($key)
    {
        $dic  =  $this->getDic();
        if(array_key_exists($key , $dic))
        {
            return $dic[$key];
        }else
        {
            echo "soory there is no key $key in lang file ";
        }
    }
    public function getErrorKey($key)
    {
        $dic  =  $this->getDic();
        $key = "text_error_$key";
        if(array_key_exists($key , $dic))
        {
            return $dic[$key];
        }else
        {
            echo "soory there is no key [$key] in lang file ";
        }
    }

}