<?php
namespace App\Lib;

class uploadFile 
{

    private $file;
    private $file_name;
    private $file_size;
    private $file_type;
    private $file_error;
    private $file_extension;
    private $file_temp_name;
    private $error = [];
    public  $file_saved_name_in_db = null;
    private $allowed_Extension = [
        "gif","jpeg", "png" , "pdf"
    ];
    public function file($file, $anyfile = null)
    {
        $this->file = $_FILES[$file];
        $this->getImageInfo($this->file , $anyfile);
        return $this;
    }

    public function getImageInfo($file , $anyfile)
    {
      
      if(! $this->isUploaded($file)){
            $this->error['nofile'] = "sorry no file uploaded";
            
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
            if($anyfile == null)
            {
                if(! $this->isImage())
                {
                    $this->error['notimage'] = "sorry this file is not image";
                }else
                {
                    // if not allowed extension
                    if(! $this->isAllowedExtension())
                    {
                        $this->error['notallowedextension'] = "soory this file is not allowed extension";
                        
                    }
                    if(! $this->isAllowedSize())
                    {
                        $this->error['notallowedsize'] = "soory this file is not allowed size";
                        
                    }
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
    public function isAllowedSize()
    {
        return $this->file_size  < 1 * 200000000;
    }
    public function isImage()
    {
        return $this->file_type === "image" ? true : false;
    }
    public function noError()
    {
        return empty($this->error);
    }

    public function move($savechat = null , $from = null , $to = null)
    {
        if($this->noError())
        {
            if($savechat != null)
            { 
                $filename =  $this->file_name;
               $destionaion =  toPublicImagesPath("app_chat/".$from."-".$to);  
            }else
            {
                $filename = \time().sha1(rand(0,1000)).".".$this->file_extension;
               $destionaion = toPublicImagesPath("profile");  
            }
            
            if(! is_dir($destionaion))
            {
                mkdir($destionaion,0777,true);
            }        
            if(move_uploaded_file($this->file_temp_name,$destionaion."/".$filename))
            {
                $this->file_saved_name_in_db = $filename;
            }
            return true;
        }else
        {
            return false;
        }
    }
    public function getFileSavedNameInDb()
    {

        return $this->file_saved_name_in_db ;
    }
    public function getFileName()
    {

        return $this->file_name ;
    }
    public function getfileExtension()
    {

        return $this->file_type ;
    }


}


/*
    //scenari
    /**
     * in request class
     * 
     * private file = [];
     * it will be like 
     * i will use /syste/http/fileupload
     * $this->request->file($file)
     * {
     * $fileinfo = $this->request->file($file);
     *  $this->file['file'] = new uploadfile($fileinfo);
     * return e$this->file['fil'];
     * 
     * }
     * 
     * */ 
    // secnario in fileupload class
    /**
     * so when i will write 
     * $file = $this->request->file($file); === it will create object from fileupload(contain file info)
     * so in fileupload class it will recieve file info
     * in constructor
     *  public function __construct($fileinfo)
     * {
     *  $this->file = $fileinfo /// array of file information
     * }
     * 
     * so  method file will return object of file upload 
     * 
     * in constrcutor method getfileinfoo() will return all info 
     *  pubblic function getinfo()
     * {
     *  $this->filename = $this->file['filename'];
     * use method pathinfo($filename); // will get extension and file name witouh extension
     * $info = pathinfo($this->filename);
     * 
     *  $this->filenameonly = $info['filename'];
     *  $this->extension = $info['filename'];
     *  $this->mimitype = $info['type'];
     *  $this->size = $this->file['type'];
     *  $this->error = $this->file['type'];
     * }
     * 
     * public function isfile()
     * {
     *   return ($this->error != upload_file_ok); 
     * }
     * 
     * pubcli function moveto($target , $filename = null)
     * {
     *      first prepare 
     * filename  =  sha1(math.rand(0,1000))."_".sha1(math.rand(0,1100));
     * filename .= $this->fileextemsion;
     * 
     * $target
     * }
     */
