<?php
if(! function_exists("pre"))
{
    function pre($excutable)
    {
        echo "<pre>";
        print_r($excutable);
        echo "</pre>";
    }
} 
if(! function_exists("pred"))
{
    function pred($excutable)
    {
        echo "<pre>";
        print_r($excutable);
        echo "</pre>";
        die;
    }
} 

if(! function_exists("toView"))
{
    function toView($path)
    {
 
        if(strpos($path,"|") !== false)
        {
        $path = explode("|" , $path);
        $dir =ucfirst( $path[0]);
        $file = $path[1];
        $fullpath = $dir."/".$file;             
        }else
        {
            $fullpath = ucfirst($path);
        }

        return VIEW_PATH.$fullpath ; 
    }
} 
if(! function_exists("toPublic"))
{
    function toPublic($path)
    {
 
        return PUBLIC_URL.$path ; 
    }
} 
if(! function_exists("toPublicImages"))
{
    function toPublicImages($path)
    {
 
        return IMAGES_URL.$path ; 
    }
} 
if(! function_exists("toPublicImagesPath"))
{
    function toPublicImagesPath($path)
    {
 
        return IMAGES_PATH.$path ; 
    }
} 
if(! function_exists("toPublicProfile"))
{
    function toPublicProfile($path)
    {
 
        return PROFILE_URL.$path ; 
    }
} 
if(! function_exists("toCss"))
{
    function toCss($path)
    {
 
        return CSS_URL.$path ; 
    }
} 
if(! function_exists("toJs"))
{
    function toJs($path)
    {
 
        return JS_URL.$path ; 
    }
} 

