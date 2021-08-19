<?php
namespace App\Controllers;
use System\Application;
class LayoutController 
{
    private $app;
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function loadLayout($content)
    {
        $data['header'] =  $this->app->load->controller("common\\header")->index();
         $data['content'] = $content;
        $data['footer'] =  $this->app->view->render("common/footer");
        echo  $this->app->view->render("layout",$data);
    }
}