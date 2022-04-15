<?php
namespace App\Models;
use App\Models\Database\AbastractModel;
use PDO;
class UsersModel extends AbastractModel
{


    protected static $primaryKey = "userId";
    protected static $tableName  = "app_users";

  
    public static function tableSchema()
    {

        return [
                "userName" => self::FILTER_STR,
                "email" => self::FILTER_STR,
                "password" => self::FILTER_STR,
                "mobile" => self::FILTER_STR,
                "lastlogin" => self::FILTER_STR,
                "subscriptionDate" => self::FILTER_STR,
                "groupId" => self::FILTER_INT,
                "verified" => self::FILTER_INT,
                "loginCode" => self::FILTER_STR,
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

    public static function geBasicinformation($keyId , $keyValue)
    {
        return static::getByQuery(
                " SELECT au.*  ,  aug.groupName ,( select GROUP_CONCAT(ap.privilegesUrl)
                from app_users au2
                inner join app_groups_privileges agp  on agp.groupId = au2.groupId
                inner join app_privileges ap on ap.privilegesId = agp.privilegesId
                where agp.groupId = au.groupId
                )   as privilegesUrl  from   app_users au
                 JOIN app_users_groups aug  ON au.groupId = aug.groupId
  
                ",  [" au.$keyId = " =>  "'$keyValue'"]) ; 
    }

    public static function getAllUserExceptLogin($keyId)
    {
        return static::getByQuery(" SELECT  au.* , aug.groupName  from app_users au  join 
        app_users_groups  aug on aug.groupId  = au.groupId " , [ " au.userId != " => $keyId]);
    }


  
}