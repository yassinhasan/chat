<?php
namespace System;
abstract class Models 
{
    public $app;
    public function __construct(Application $app)
    {
        $this->app = $app;
    }
    public function getAll()
    {

        $users = $this->app->db->select("*")->from($this->tablename)->fetchAll();
        return $users;
    }
    public function getAllExceptLoginUser($id)
    {
        $users = $this->app->db->select(" * ")->from(" users ")->where("id !=  $id " )->fetchAll();
        return $users;
    }

}