<?php
namespace App\Models;
use App\Models\Database\AbastractModel;
class UsersgroupsprivilegesModel extends AbastractModel
{


    protected static $primaryKey = "id";
    protected static $tableName  = "app_groups_privileges";

    public static function tableSchema()
    {
        return [
            "groupId" => self::FILTER_INT,
            "privilegesId" =>  self::FILTER_INT,
        ];
    }

    public static function getUserPrivileges($id)
    {
        // join user
        $userPrivileges = UsersgroupsprivilegesModel::getByQuery(" select ap.privilegesUrl  from app_users au
                inner join app_groups_privileges agp  on agp.groupId = au.groupId
                inner join app_privileges ap on ap.privilegesId = agp.privilegesId
        " , ["au.groupId" => $id]) ;
        foreach($userPrivileges as $key=> $value)
        {
            $selectedKeys[] = $value->privilegesUrl;
        }
        return empty($selectedKeys) ? false : $selectedKeys;
    }
    public static function getUserPrivilegesId($id)
    {
        // join user
        $userPrivileges = parent::getBy("privilegesId" , ["groupId = " => $id]);
        foreach($userPrivileges as $key=> $value)
        {
            $selectedKeys[] = $value->privilegesId;
        }
        return empty($selectedKeys) ? false : $selectedKeys;
    }



}