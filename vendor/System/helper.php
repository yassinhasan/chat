<?php

!defined("DS") ? define("DS",DIRECTORY_SEPARATOR) : DS;
if(!function_exists("pre"))
{
    function pre($key)
    {
        echo "<pre>";
        print_r($key);
        echo "</pre>";
    }
}

if(!function_exists("get_array_values"))
{
    function get_array_values($array,$key,$default = null)
    {
       if(array_key_exists($key,$array))
       {
           return $array[$key];
       }
       else
       {
           return $default;
       }
    }
}
if(!function_exists("toPublicDirectory"))
{
    function toPublicDirectory($file)
    {
        global $app;
        global $app;
        $dir =   $app->file->dir()."public".DS.$file;
        $dir = str_replace("\\","/",$dir);
        return $dir;
    }
}
if(!function_exists("toChat"))
{
    function toChat($file)
    {
        global $app;
        $dir =  $app->request->baseUrl()."public".DS."chat".DS.$file;
        $dir = str_replace("\\","/",$dir);
        return $dir;
    }
}
if(!function_exists("toBase"))
{
    function toBase($file)
    {
        global $app;
        $dir =  $app->request->baseUrl().$file;
        $dir = str_replace("\\","/",$dir);
        return $dir;
    }
}
