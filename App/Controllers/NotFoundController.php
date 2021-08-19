<?php 
namespace App\Controllers;

use System\Controller;

class NotFoundController extends Controller
{
    public function index()
    {

        $this->app->html->setTitle("notfound");
        $this->app->layout->loadLayout("notfound");
    }
}