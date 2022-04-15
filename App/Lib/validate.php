<?php
namespace App\Lib;

use App\Models\UsersModel;
use App\Lib\encryptDecrypt;
use Config\connection;
trait validate 
{
    use encryptDecrypt;
    private $error = [];
    private $pattern = [
        "int" => "/^[0-9]+$/" , 
       "string" => "/^[a-zA-Z0-9](_(?!(\.|_))|\.(?!(_|\.))|[a-zA-Z0-9])+[a-zA-Z0-9]$/"
  //      "string" => "/^[A-Za-z][A-Za-z0-9_]+$/"
    ];
    public function getValue($value)
    {
        return $_POST[$value] = isset($_POST[$value]) ? $_POST[$value] : null;
    }
    public function required($value , $message = null)
    {
        if($this->hasError($value))
        {
            return $this;
        }
        $inputvalue = $this->getValue($value);

        if($inputvalue == ""  || $inputvalue == null)
        {
            if($message == null)
            {
                $this->error[$value] = sprintf($this->lang->getErrorKey("required"),$value);
            }else
            {
                $this->error[$value] = $message;
            }
        }
         return $this;
    }
    public function matchOldPassword(array $value , $message = null)
    {
        // ["oldpasswrd" , id=12] 
        // $password = value[0] 
        // id = $value[1]

        $clientPassword = $value[0];
        $id = $value[1];
        if($this->hasError($clientPassword))
        {
            return $this;
        }
        $inputvalue = $this->getValue($clientPassword);
        $oldPassword = UsersModel::getBy(" password " , [" userId = " , $id]);
        $oldPassword = array_shift($oldPassword);
        $oldPassword = $this->decrypt($oldPassword->password);;
        if($oldPassword !== $inputvalue)
        {
            if($message == null)
            {
                $this->error[$clientPassword] = sprintf(" sorry this %s is not correct ",$clientPassword);
            }else
            {
                $this->error[$clientPassword] = $message;
            }                
        }

         return $this;
    }

    public function min($value , $min , $message = null)
    {
        if($this->hasError($value))
        {
            return $this;
        }
        $inputvalue = $this->getValue($value);
        if( strlen($inputvalue) < $min)
        {
            if($message == null)
            {
                $this->error[$value] = sprintf($this->lang->getErrorKey("required"),$value,$min);
            }else
            {
                $this->error[$value] = $message;
            }
        }
         return $this;
    }
    public function max($value , $max , $message = null)
    {
        if($this->hasError($value))
        {
            return $this;
        }
        $inputvalue = $this->getValue($value);
        if( mb_strlen($inputvalue) > $max)
        {
            if($message == null)
            {
                $this->error[$value] = sprintf("soory  %s shoud not  more than than %d",$value,$max);
            }else
            {
                $this->error[$value] = $message;
            }
        }
         return $this;
    }
    public function between($value , $min ,$max, $message = null)
    {
        if($this->hasError($value))
        {
            return $this;
        }
        $inputvalue = $this->getValue($value);
        if($inputvalue == "" | $inputvalue == null) return $this; 
        if( mb_strlen($inputvalue) < $min or mb_strlen($inputvalue) > $max)
        {
            if($message == null)
            {
                $this->error[$value] = sprintf($this->lang->getErrorKey("between"),$value,$min , $max);
            }else
            {
                $this->error[$value] = $message;
            }
        }
         return $this;
    }
    public function isValid()
    {
        
        return empty($this->error);        
    }
    public function getMessage()
    {
        return $this->error;
    }
    public function hasError($input)
    {
        return array_key_exists($input , $this->error);
    }

    public function isInt($value , $message = null)
    {
        if($this->hasError($value))
        {
            return $this;
        }
        $inputvalue = $this->getValue($value);
        if(! preg_match($this->pattern["int"] , $inputvalue))
        {
            if($message == null)
            {
                $this->error[$value] = sprintf($this->lang->getErrorKey("isInt"),$value);
            }else
            {
                $this->error[$value] = $message;
            }
        }
        return $this;
    }
    public function isString($value , $message = null)
    {
        if($this->hasError($value))
        {
            return $this;
        }
        $inputvalue = $this->getValue($value);
        if($inputvalue == "" | $inputvalue == null) return $this; 
        if(! preg_match($this->pattern["string"] , $inputvalue))
        {
            if($message == null)
            {
                $this->error[$value] = sprintf("soory  %s must be match required ",$value);
            }else
            {
                $this->error[$value] = $message;
            }
        }
        return $this;
    }
    public function isEmail($value, $message = null)
    {
        if($this->hasError($value))
        {
            return $this;
        }
        $inputvalue = $this->getValue($value);
        if(! filter_var($inputvalue,FILTER_VALIDATE_EMAIL))
        {
            if($message == null)
            {
                $this->error[$value] = sprintf("soory  %s must be valid email ",$value);
            }else
            {
                $this->error[$value] = $message;
            }
        }
        return $this;
    }

    public function isMatched($value1 , $value2 , $message = null)
    {
        if($this->hasError($value2))
        {
            return $this;
        }
        $inputvalue1 = $this->getValue($value1);
        $inputvalue2 = $this->getValue($value2);
        if($inputvalue1 !== $inputvalue2)
        {
            if($message == null)
            {
                $this->error[$value1] = sprintf("soory  %s not matched " ,$value1);
            }else
            {
                $this->error[$value1] = $message;
            }
        }
        return $this;
    }

    public function exists(array $value, $message = null)
    {

        $columnName = $value[0];
        $tableName = $value[1];
        if($this->hasError($columnName))
        {
            return $this;
        }
        $sql = "";
        $inputvalue = $this->getValue($columnName);
        if(count($value) == 2)
        {
        $sql .="SELECT ".$columnName. " FROM ".$tableName. " WHERE ".$columnName." = '".$inputvalue."'";            
        }else if(count($value) == 4)
        {
            $exceptionColumn = $value[2];
            $exceptionValue = $value[3];
            $sql .= "SELECT ".$columnName. " FROM ".$tableName. " WHERE ".$columnName." = '".$inputvalue."' AND ".$exceptionColumn." != ".$exceptionValue; 
        }
        $conn = connection::getInstance();
        $stmt = $conn->prepare($sql);
        if($stmt->execute())
        {
            if($stmt->rowCount() > 0 )
            {
                if($message == null)
                {
                    $this->error[$columnName] = sprintf("soory  %s exists before ",$columnName);
                }else
                {
                    $this->error[$columnName] = $message;
                }
            }
        }
        return $this;

    }

    public function requireImage($file)
    {

        if(! $this->uploadfile->file($file)->isUploaded())
        {

            $this->error["image"] = " sorry no file uploaded";
   
        }
        return $this;

    }

    public function moveWithOutRequire($file,array $paramter = [] , $anyfile = null)
    {

        if( $this->uploadfile->file($file,$anyfile)->isUploaded())
        {
            if(!empty($paramter))
            {
                $savechat = $paramter[0];
                $from = $paramter[1];
                $to = $paramter[2];
                if(!$this->uploadfile->move($savechat , $from , $to))
                {
                    $errors = $this->uploadfile->getEroors();
                    foreach($errors as $key=>$value)
                    {
                        $this->error['image'][$key] = $value ;
                    }
                } 
            }else
            {
                if(!$this->uploadfile->move())
                {
                    $errors = $this->uploadfile->getEroors();
                    foreach($errors as $key=>$value)
                    {
                        $this->error['image'][$key] = $value ;
                    }
                }  
            }

        }
        return $this;
    }

 
    
}