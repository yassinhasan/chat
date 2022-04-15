<?php
namespace App\Lib;

trait  response
{
    public function json($array)
    {
        echo json_encode($array);
    }
}
