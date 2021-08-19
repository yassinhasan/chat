<?php 
namespace App\Controllers;

use System\Controller;

class UsersController extends Controller
{
    public function index()
    {
        $data['users'] = "users";
        $data['users2'] = "users2";
        echo $this->app->view->render("users",$data);
    }
}