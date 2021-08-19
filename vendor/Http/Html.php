<?php
namespace Http;
use System\Application;
class Html 
{
    private $app;
    private $title;
    public function __construct(Application $app)
    {
        $this->app = $app;
    }
    public function setTitle($title)
    {
        $this->title= $title;
    }
    public function getTitle()
    {
        return $this->title;
    }
    
}