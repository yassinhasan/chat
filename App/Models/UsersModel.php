<?php
namespace App\Models;

use System\Models;

class UsersModel extends Models
{
    protected $tablename = "users";
    private $logincode;
    public function insert()
    {
        $loginkey = \sha1(time());
        $image = $this->app->upload->file('image')->move()->fileSavedNameInDb();
        $password = $this->app->request->post('password') == "" ? "" : password_hash($this->app->request->post('password'),PASSWORD_DEFAULT);
        $result = $this->app->db->data([
            "unique_id" => \time(),
            "firstname" => $this->app->request->post('firstname'),
            "lastname" => $this->app->request->post('lastname'),
            "email" => $this->app->request->post('email'),
            "password" => $password,
            "status" => 'active',
            "image" => $image,
            'logincode' =>$loginkey,
            'logintime' => time()
           
        ])->insert($this->tablename);
        $this->logincode = $loginkey;
        return $result;
    }
    public function getLoginCode()
    {
        return $this->logincode;
    }

    


    
}