<?php
namespace App\Lib;

trait redirect 
{

    public function redirect($path)
    {
        session_write_close();
        header("location: $path");
        exit;
    }
}