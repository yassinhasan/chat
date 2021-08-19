<?php
namespace App\Controllers;

use System\Controller;

class LoginController extends Controller
{
    public function index()
    {
        $usermodel = $this->app->load->model("login");
        if($usermodel->isLoged())
        {
            header("location: /");
        }

        $this->app->html->setTitle("login");
        $this->app->layout->loadLayout($this->app->view->render("login"));
    }
    public function submit()
    {
        if($this->isValid())
        {
            $email = $this->app->request->post("email");
            $password = $this->app->request->post("password");
            $loginmodel = $this->app->load->model("login");
           if($loginmodel->validateLogin($email,$password) !== null)
           {
                $user = $loginmodel->user();
                $this->app->session->set("loginkey",$user->logincode);
                $this->app->session->set("logintime",$user->logintime);
                // $this->app->cookie->setCookie("loginkey",$user->logincode,1);
                $this->json['success'] = 'wellcome back'.$user->firstname;
                $this->json['redirect'] = "/";
                
           }
           else
           {
               $this->json['error'] = 'email or password is invalid';
           }

        }
        return $this->json();

    }
    public function isValid()
    {
        $valid = $this->app->validator
        ->require('email')
        ->email('email')
        ->require('password')
        ->valid();
        if( $valid == false)
        {
        $this->json['error'] = $this->app->validator->getErrorMessages();

        }
        return empty($this->json['error']);
    }
}