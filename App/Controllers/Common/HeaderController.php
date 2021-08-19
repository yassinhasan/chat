<?php
namespace App\Controllers\Common;

use System\Controller;

class HeaderController extends Controller 
{
    public function index()
    {
       
       $data['title'] = $this->app->html->getTitle("header");
       return $this->app->view->render("common/header" , $data);
    }
}