<?php
namespace App\Controllers;

use System\Controller;

class SignupController extends Controller
{
    public function index()
    {
        $this->app->html->setTitle("signup");
      
        $this->app->layout->loadLayout($this->app->view->render("signup"));
    }
    public function submit()
    {

        // TODO:: fenish validatior class 
        // TODO:: how to connet controller to model
        
 
     //   $this->json['es'] = $this->app->validator->getErrorMessages();

        if($this->isValid())
        {
           $user = $this->app->load->model('users');
           if($user->insert())
           {
                $loginkey = $user->getLoginCode();
                $this->app->session->set("loginkey",$loginkey);
                $this->app->cookie->setCookie("loginkey",$loginkey,1);
                $this->json['success'] = "user inserted  success";
                $this->json['redirect'] = "/";
           }
        }
        return $this->json();
    }

    public function isValid()
    {
        $valid = $this->app->validator->require('firstname')
        ->require('lastname')
        ->require('email')
        ->email('email')
        ->require('password')
        ->exists('email','users')
        ->exists('lastname','users')
        ->image('image')->valid();
        if( $valid == false)
        {
        $this->json['error'] = $this->app->validator->getErrorMessages();

        }
        return empty($this->json['error']);
    }
}