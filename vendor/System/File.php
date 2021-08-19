<?php
namespace System;
class File 
{
    private $dir;
    const DS= DIRECTORY_SEPARATOR;
    public function __construct($dir = null)
    {
     $this->dir= $dir;
    }
    public function dir()
    {
        return $this->dir.self::DS;
    }
    public function toVendor()
    {
        return $this->dir.SELF::DS."Vendor".self::DS;
    }

    public function require($file)
    {
    
        require_once $this->dir().self::DS.$file;
    }
    public function toFile()
    {
        return $this->dir.self::DS;
    }
    public function toBase($file)
    {
    
        require_once $this->dir().self::DS.$file;
    }
    
}