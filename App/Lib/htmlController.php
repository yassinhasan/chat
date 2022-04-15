<?php
namespace App\Lib;
class htmlController
{
    private $view;
    private $data = [];
    private $output;
    public function __construct($view, $data)
    {
        $this->prepareView($view);
        
        $this->data = $data;
        $this->prepareOutput();
    }

    public function prepareView($view)
    {
        $view = toView($view);
        if(file_exists($view))
        {
            $this->view = $view;
        }else
        {
            echo "sorry $view is not found";
        }
    }
    public function prepareOutput()
    {
        ob_start();
        extract($this->data);
        require_once $this->view;
        $this->output = ob_get_contents();
        ob_end_clean();
    }
    public function __toString()
    {
        return $this->output;
    }
}