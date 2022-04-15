<?php
namespace App\Models;
use App\Models\Database\AbastractModel;
class UsersgroupsModel extends AbastractModel
{


    protected static $primaryKey = "groupId";
    protected static $tableName  = "app_users_groups";

  
    public static function tableSchema()
    {
        return [
            "groupName" =>  self::FILTER_STR,
        ];
    }





    
}



