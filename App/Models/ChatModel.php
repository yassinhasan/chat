<?php
namespace App\Models;
use App\Models\Database\AbastractModel;
use PDO;
class ChatModel extends AbastractModel
{


    protected static $primaryKey = "id";
    protected static $tableName  = "app_chat";

  
    public static function tableSchema()
    {	
        return [
                "msg" => self::FILTER_STR,
                "fromId" => self::FILTER_INT,
                "toId" => self::FILTER_INT,
                "created" => self::FILTER_STR,
                "status" => self::FILTER_STR,
            ];            

    }
    public function __get($name)
    {
        return $this->$name;
    }
    public function __set($name, $value)
    {
        $this->$name = $value;
    }


    public static function getAllMsg($fromId , $toId)
    {
        return static::getByQuery( "select ap.* , au.userName from app_chat ap 
            inner join app_users au 
            on au.userId = ap.fromId
            inner join app_users au2 
            on au2.userId = ap.toId
        where ( ap.fromId = $fromId AND ap.toId = $toId  ) OR (ap.fromId = $toId AND ap.toId = $fromId ) 
        ");
    }

    public static function loadAllChat($from , $loggeduser)
    {
        $msg = static::getByQuery( " 
            SELECT ac.msg , ac.created , (select count(status) from app_chat where `status` = 'unread' AND fromId = $from ) as unread FROM app_chat ac where 
                (ac.fromId = $from and ac.toId = $loggeduser) 
                or (ac.toId = $from and ac.fromId = $loggeduser)
                order by ac.created desc limit 1                    
        ");
        if(is_array($msg) and $msg != false)
        {
            return array_shift($msg);
        }
    }

    public static function updateUnreadMsfs($from , $to)
    {
       return static::getByQuery( " 
            update app_chat set status = 'read' where (fromId = $from and toId = $to) or (fromId = $to and toId = $from)
    ");
    }



  
}