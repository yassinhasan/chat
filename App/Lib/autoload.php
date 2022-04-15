<?php
namespace App\Lib;
class autoload
{
    public static function prepareClasses($class)
    {
        
        if(strpos($class,"\\") !== false )
        {
            $file = BASE_PATH.str_replace("\\",DIRECTORY_SEPARATOR , $class);
            $file = $file.".php";
            
        }else
        {
            $file = BASE_PATH.$class.".php"; 
        }

      if(! file_exists($file))
      {
         return;
      }else
      {
          return require_once($file);
      }
    }


}
  
 spl_autoload_register(__NAMESPACE__."\autoload::prepareClasses");
