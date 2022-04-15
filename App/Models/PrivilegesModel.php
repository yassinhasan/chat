<?php
namespace App\Models;
use App\Models\Database\AbastractModel;
class PrivilegesModel extends AbastractModel
{


    protected static $primaryKey = "privilegesId";
    protected static $tableName  = "app_privileges";

  
    public static function tableSchema()
    {
        return [
            "privilegesTilte" => self::FILTER_STR,
            "privilegesUrl" =>  self::FILTER_STR,
        ];
    }

    public static function  prepareSelectAllSql() :string
    {
        $sql = " SELECT * FROM  " .get_called_class()::$tableName. " ORDER BY privilegesUrl ASC" ;
        return $sql;
    }
    
 
}



