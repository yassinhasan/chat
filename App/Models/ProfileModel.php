<?php
namespace App\Models;
use App\Models\Database\AbastractModel;
use PDO;
class ProfileModel extends AbastractModel
{


    protected static $primaryKey = "id";
    protected static $tableName  = "app_users_profile";

  
    public static function tableSchema()
    {

        return [
                "userId" => self::FILTER_INT,
                "firstName" => self::FILTER_STR,
                "lastName" => self::FILTER_STR,
                "address" => self::FILTER_STR,
                "dateOfBirth" => self::FILTER_STR,
                "image" => self::FILTER_STR,
                "gender" => self::FILTER_STR,
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
}