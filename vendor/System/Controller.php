<?php 
namespace System;
abstract class Controller 
{
    public $app;
    public $json = [];
    public function __construct(Application $app)
    {
        $this->app = $app;
    }
    public function json()
    {
        echo \json_encode($this->json);
    }
}