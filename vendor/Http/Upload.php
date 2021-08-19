<?php
namespace Http;
use System\Application;
class Upload
{
    private $app;
    public function __construct(Application $app)
    {
        $this->app = $app;
    }
    public function file($file)
    {
        // scenario  
        //  $this->app->upload($this->app->request->file("image"));
        // here  i send file to this function
        // then $file  = new uploadfile($file);
        // $file->isimage()-> and so on

        $image  = new UplaodImage($file);
        return $image;
    }
}