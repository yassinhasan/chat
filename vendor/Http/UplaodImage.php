<?php
namespace Http;
class UplaodImage 
{
    private $file;
    private $file_name;
    private $file_size;
    private $file_type;
    private $file_error;
    private $file_extension;
    private $file_temp_name;
    private $error = [];
    private $file_saved_name_in_db;
    private $allowed_Extension = [
        "gif","jpeg","png"
    ];
    public function __construct($file)
    {
        $this->file = $_FILES[$file];
        $this->getImageInfo($this->file);
    }

    public function getImageInfo($file)
    {
      
      if(! $this->isUploaded($file)){
            $this->error[] = "sorry no file uploaded";
            
        }else
        {
            $this->file = $file;
            $this->file_name = $file['name'];
            $this->file_size = $file['size'];
            $this->file_error = $file['error'];
            $this->file_temp_name = $file['tmp_name'];
            $file_extension = explode("/",$file['type']);
            $this->file_type = array_shift($file_extension);
            $this->file_extension = $file_extension[0]; 
            // if not image
            if(! $this->isImage())
            {
                $this->error[] = "sorry this file is not image";
            }

            else
            {
                // if not allowed extension
                if(! $this->isAllowedExtension())
                {
                    $this->error[] = "soory this file is not allowed extension";
                    
                }
            }

        }
    }

    public function getEroors()
    {
        return $this->error;
    }

    public function isUploaded()
    {
       if(isset($this->file))
       {
       return $this->file['error'] === 0 ? true : false;           
       } 

    }
    public function isAllowedExtension()
    {
        return in_array($this->file_extension , $this->allowed_Extension);
    }
    public function isImage()
    {
        return $this->file_type === "image" ? true : false;
    }
    public function noError()
    {
        return empty($this->error);
    }

    public function move()
    {
        if($this->noError())
        {
            $filename = \time().sha1(rand(0,1000)).".".$this->file_extension;
            
            $destionaion = toPublicDirectory("chat/uploades/images");  
            if(! is_dir($destionaion))
            {
                mkdir($destionaion,0777,true);
            }        
            if(move_uploaded_file($this->file_temp_name,$destionaion."/".$filename))
            {
                $this->file_saved_name_in_db = $filename;
            }
        }
        return $this;

    }
    public function fileSavedNameInDb()
    {
        if($this->noError())
        {
            return $this->file_saved_name_in_db;
        }

    }
}