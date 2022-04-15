<?php
namespace App\Lib;

trait filter 
{
    public function filterInt($int)
    {

        
        return  filter_var($int,FILTER_SANITIZE_NUMBER_INT);
    }
    public function filterString($string)
    {
        trim($string , " \r\n\t");
        $string = htmlentities(strip_tags($string) , ENT_COMPAT, "UTF-8");
        return filter_var($string,FILTER_SANITIZE_STRING);
    }
}