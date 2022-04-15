<?php
namespace App\Models;
use App\Models\Database\AbastractModel;
class EmployeeModel extends AbastractModel
{


    protected static $primaryKey = "id";
    protected static $tableName  = "employee";

  
    public static function tableSchema()
    {
        return [
            "firstname" => self::FILTER_STR,
            "age" => self::FILTER_INT,
        ];
    }



    
}



