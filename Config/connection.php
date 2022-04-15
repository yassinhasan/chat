<?php ;
namespace Config;
use PDO;
class connection extends AbstractDatabaseHandler
{

    protected static $conn = null;
    private function __construct(){}
    private function __clone(){}
    protected static function init()
    {
            try {
                $dsn ="mysql:host=".self::HOSTNAME.";dbname=".self::DBNAME;
                self::$conn  = new PDO( $dsn , self::DBUSERNAME , self::DBPASSWORD,array (
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_BOTH , 
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION  , 
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8'
                )); 
                return self::$conn;
            } catch (\PDOException $e) {
               echo  $e->getMessage();
            }
    }

    public static function getInstance()
    {
        static::init();
        if(static::$instance == null)
        {   
            static::$instance = self::$conn;
        }
        return self::$instance;

    }

}


