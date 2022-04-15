<?php
namespace App\Lib;
class templateHelper 
{
    public function getBreadCrumb()
    {
        $output = '
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="custom-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/chat/">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">'.$this->prepareBreadCrumb().'</li>
        </ol>
        </nav>';
        echo $output.'dasdasd';
    }
    public function prepareBreadCrumb()
    {
            echo $this->app->getContrller();

    }
    public function isHome()
    {
        return $this->app->getContrller() == "home" ? true : false;
    }
}