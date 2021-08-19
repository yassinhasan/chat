<?php
namespace Http;

use DirectoryIterator;
use System\Application;
class View 
{
    private $app;
    private $viewpath ;
    private $data;
    private $output;
    public function __construct(Application $app)
    {
        $this->app = $app;

    }
    public function preparePath($path)
    {
        $path = "App".DIRECTORY_SEPARATOR."Views".DIRECTORY_SEPARATOR.$path.".php";
       
        
       return  $this->viewpath = $path;
    }

    public function render($path,$data = [])
    {
        $viewpath = $this->preparePath($path);
        $this->viewpath = $viewpath;
        $this->data = $data;
        echo $this;
    }

    public function __toString()
    {
        $this->setoutput();
       return $this->output;
    }

    public function setoutput()
    {
        
        ob_start();
        extract($this->data);
        require_once $this->app->file->toFile().$this->viewpath;
        $output = ob_get_clean();
        $this->output = $output;
    }

} 