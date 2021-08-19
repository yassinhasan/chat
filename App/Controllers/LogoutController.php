<?php
namespace App\Controllers;

use Collator;
use System\Controller;

class LogoutController extends Controller
{
    public function index()
    {

        $usermodel = $this->app->load->model("login");

        if($usermodel->isLoged())
        {
            $user = $usermodel->user();
            $time = time();
            $this->app->db->data("status = 'offline' , logintime = $time ")->where(["logincode = ?" => $user->logincode])->update('users');
            
            if($this->app->session->has("loginkey"))
            {
                $this->app->session->remove('loginkey');
            }
            // if($this->app->cookie->has("loginkey"))
            // {

            //     $this->app->cookie->remove('loginkey');
            //     unset($_COOKIE['loginkey']);

            // } 
            $this->app->request->redirectTo("login");
        }
    }
}