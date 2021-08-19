<?php
namespace App\Controllers\Common;

use System\Controller;

class FotterController extends Controller 
{
    public function index()
    {
       
       return $this->app->view->render("common/fotter");
    }
}