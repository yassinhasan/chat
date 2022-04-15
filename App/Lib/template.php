<?php
namespace App\Lib;
class template extends templateHelper
{
    private $parts;
    private $data;
    private $view;
    private $css;
    private $js;
    private $execlude =[];
    private $register;
    private $blocks = [];

    public function __construct(register $register)
    {
       
        $this->parts = $this->setTemplateParts();
        $this->register = $register;
    }
    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->profile ,$name] , $arguments);
    }

    public function __get($name)
    {
        return $this->register->$name;
    }
    public function setTemplateParts()
    {
         $template_parts = include "Config/templateconfig.php";
         return $template_parts;
    }
    public function addExclude(array $execlude)
    {
       if(!empty($execlude))
       {
            $this->setfilterParts($execlude);
            $beforeExclude = $this->parts['template_parts']['blocks'];
            $filter = array_filter($beforeExclude , function($key)
            {
                return !in_array($key , $this->getFilterParts());
            },ARRAY_FILTER_USE_KEY);   
            $this->blocks =$filter;       
       }else
       {
           $this->blocks = $this->parts['template_parts']['blocks'];
       }

    }

    public function setfilterParts($execlude)
    {
        $this->execlude = $execlude;
    }
    public function getFilterParts()
    {
        return $this->execlude;
    }
    public function addCss($link)
    {
        $this->css[] = $link;
        return $this;
    }
    public function addJs($link)
    {
        $this->js[] = $link;
        return $this;
    }
    public function setDatae($data)
    {
        $this->data =  $data;
        return $this;
    }
    public function setView($view)
    {
        $this->view =  $view;
        return $this;

    }
    private function renderHeaderStart()
    {
        extract($this->data);
        require_once TEMPLATE_PATH."templateheaderstart.php";
    }

    private function renderHeaderEnd()
    {
        require_once TEMPLATE_PATH."templateheaderend.php";
    }
    private function renderFooterEnd()
    {
        require_once TEMPLATE_PATH."templatefooterend.php";
    }
    private function renderHeaderLinks()
    {
        $output = "";
        $parts = $this->parts['template_parts'];
        if(!empty($parts))
        {
            $headerlinks = $parts['header_links'];
            if(!empty($headerlinks))
            {
                foreach($headerlinks  as $key=>$value)
                {
                    if(!empty($headerlinks[$key]))
                    {
                    if($key == "css")
                    {
                        foreach($value as $link)
                        {
                           $output .= $link;
                        }
                    }else
                    {

                    }
                    }
                }
            }
        }else
        {
            trigger_error("soory you must enter body of view" ,  E_USER_NOTICE);
        }
        if(!empty($this->css))
        {
          
           foreach($this->css as $link)
           {
            $output .= "<link rel='stylesheet' href='$link' >";
           }
        }
        echo $output;
    }
    private function renderFooterLinks()
    {
        $output = "";
        $parts = $this->parts['template_parts'];
        if(!empty($parts))
        {
            $headerlinks = $parts['footer_links'];
            if(!empty($headerlinks))
            {
                foreach($headerlinks  as $key=>$value)
                {
                    if(!empty($headerlinks[$key]))
                    {
                        foreach($value as $link)
                        {
                           $output .= $link;
                        }
                    }
                }
            }
        }else
        {
            trigger_error("soory you must enter body of view" ,  E_USER_NOTICE);
        }
        if(!empty($this->js))
        {
          
           foreach($this->js as $link)
           {
            $output .= "<script src='$link' type='module'></script>";
           }
        }
        echo $output;
    }
    private function rednerBlocks()
    {
        if(!empty($this->blocks))
        {
             $blocks = $this->blocks;
        }else
        {
             $blocks = $this->parts['template_parts']['blocks'];            
        }

        if(!empty($blocks))
        {
            if(!empty($blocks))
            {
                foreach($blocks  as $key=>$value)
                {
                    if($key == ":view")
                    {
                        extract($this->data);
                        require_once $this->view;
                    }else
                    {
                         extract($this->data);
                        require_once $value;
                    }
                }
            }
        }else
        {
            trigger_error("soory you must enter body of view" ,  E_USER_NOTICE);
        }
    }

    public function render()
    {
        $this->renderHeaderStart(); 
        $this->renderHeaderLinks(); 
        $this->renderHeaderEnd();
        $this->rednerBlocks();
        $this->renderFooterLinks();
        $this->renderFooterEnd();
    }

}