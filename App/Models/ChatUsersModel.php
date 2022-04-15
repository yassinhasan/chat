<?php
namespace App\Models;
use App\Models\Database\AbastractModel;
use PDO;
class ChatUsersModel extends AbastractModel
{


    protected static $primaryKey = "id";
    protected static $tableName  = "app_chat_users";

  
    public static function tableSchema()
    {
        return [
                "userId" => self::FILTER_INT,
                "token" => self::FILTER_STR,
                "connectionId" => self::FILTER_INT,
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

    public function getAllUser()
    {
        return static::getByQuery(
            "
            select ( select  count(*) from app_chat ap
                where ap.toId = acu.userId AND ap.status = 'unread'
            ) as count , acu.userId , acu.token , acu.connectionId , acu.status , au.userName  , au.lastLogin  ,
                        aup.firstName , aup.lastName , aup.gender , aup.image
            from app_chat_users acu 
                INNER JOIN app_users au ON au.userId = acu.userId 
                INNER JOIN app_users_profile  aup ON aup.userId = acu.userId 
            
                " ) ; 
    }
    public static function getAllUserExcpetLogin($loginId)
    {
        return static::getByQuery(
            "
            select ( select  count(*) from app_chat ac
                where (ac.fromId = acu.userId AND ac.toId = $loginId ) AND ac.status = 'unread' 
            ) as count , acu.userId , acu.token , acu.connectionId , acu.status , au.userName  , au.lastLogin  , 
                        aup.firstName , aup.lastName , aup.gender , aup.image
            from app_chat_users acu 
                INNER JOIN app_users au ON au.userId = acu.userId 
                INNER JOIN app_users_profile  aup ON aup.userId = acu.userId 
                where acu.userId != $loginId
            
                " ) ; 
    }

    public static function updateToLogin($key , $id)
    {
        return static::byQuery(" UPDATE app_chat_users SET status  =  
           'login'
            WHERE `$key` = $id ; ");
    }
    public static function updateToLogout($key,$id)
    {
        return static::byQuery(" UPDATE app_chat_users SET `status`  =  
           'logout' 
            WHERE  `$key`  = $id  ");
    }

    public static function updateConnectionId($token , $connectionId )
    {
        return static::byQuery(" UPDATE app_chat_users SET `connectionId`  =  
           $connectionId  , `status` = 'login'
            WHERE `token` = '$token'  ");
    }



  
}