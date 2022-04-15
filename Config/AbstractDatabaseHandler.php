<?php
namespace Config;
abstract class AbstractDatabaseHandler 
{
    CONST HOSTNAME = "localhost" ; 
    CONST DBNAME = "cms" ;
    CONST DBUSERNAME = "root" ;
    CONST DBPASSWORD = "hasan123" ;
    protected static $instance = null;
    protected static $conn = null;
    abstract static protected  function init();
    abstract protected static function getInstance();

}