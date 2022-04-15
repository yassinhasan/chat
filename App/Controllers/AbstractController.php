<?php
namespace App\Controllers;

use App\Lib\htmlController;
abstract class AbstractController
{
    protected $controller;
    protected $action;
    protected $params;
    protected $data = [];
    protected $json = [];
    protected htmlController $html;
    protected $register;
    public function __construct()
    {
    }
    public function setController($controller)
    {
        $this->controller = $controller;
    }
    public function setAction($action)
    {
        $this->action = $action;
    }
    public function setParams($params)
    {
        $this->params = $params;
    }
    public function setRegister($register)
    {
        $this->register = $register;
    }

    public function notfound()
    {
       $this->_view();
    }
    public function getContrller()
    {
        return $this->controller;
    }
    public function getAction()
    {
        return $this->action;
    }

    public function __get($name)
    {
        return $this->register->$name;
    }

    public function render($view,$data)
    {
        return new htmlController($view,$data);
    }
    
    public function _view()
    { 

        if($this->controller == "NotFound")
        {
 
            $view = VIEW_PATH.ucfirst($this->controller).DS.lcfirst($this->action).".php"; 
        }else
        {
            $view = VIEW_PATH.ucfirst($this->controller).DS.lcfirst($this->controller).lcfirst($this->action).".php";       
        }
        if(file_exists($view))
        {
            
            if(!is_null( $this->lang->getDic()))
            {  
                $data = array_merge($this->data , $this->lang->getDic());
            }else
            {
                $data = $this->data;
            }
            
            $this->template->setDatae($data)->setView($view)->render();
        }else
        {
            echo "soory this page ".$view ." -- is not created yet";
        }
    }
}