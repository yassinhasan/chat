<?php
namespace App\Models;

use System\Models;

class LoginModel extends Models
{
    protected $tablename = "users";

    protected $user = "";
    // i will take email and password from login by method isvaliddata in logincontroller
    // check first if user is present by email
    // then make verify to this password and password by user 
    // return true or false 
    // before return true i will make property will contain user data 
    public function validateLogin($email,$password)
    {

        $user = $this->app->db->select('*')->from('users')->where(['email = ?' => $email])->fetch();
       if($user != null)
       {
           $this->user = $user;
          return \password_verify($password,$user->password);
       }
       else
       {
         return  $this->user = null;
       }


    }


    public function user()
    {
        return $this->user;
    }

    public function isLoged()
    {
       $logincode = "not avaiblebe";

    //    if($this->app->cookie->has("loginkey"))
    //    {
    //     $logincode = $this->app->cookie->get("loginkey");   
    //    } 
       if($this->app->session->has("loginkey"))
       {
        $logincode = $this->app->session->get("loginkey");
        $this->app->db->data("status = 'active'")->where(["logincode = ?" => $logincode])->update('users');
      
       }
       $user = $this->app->db->from(' users ')->select(" * ")->where(["logincode = ?" => $logincode])->fetch();
       $this->user = $user;
        if($user != null)
        {
            $this->app->session->set("outgoing_id" , $user->unique_id);
            return true;
        }
        else
        {
            return false;
        }
    }

    public function getAllExceptLoginUser($id)
    {
        $users = $this->app->db->select(" * ")->from(" users ")->where(" unique_id !=  $id " )->fetchAll();
        return $users;
    
    }
    

}
// $t = new UsersModel();
// $t->qyery("select * from users");
// \pre($t);
