<?php 
namespace System;
class Session 
{
    public function start()
    {
        session_start();
    }

    public function set($key,$value)
    {
        return $_SESSION[$key] = $value;
    }
    public function has($key)
    {
        return isset($_SESSION[$key]);
    }
    public function remove($key)
    {
        if($this->has($key))
        {
            unset($_SESSION[$key]);
        }
        else
        {
            "soory this $key is not found";
        }
    }
    public function get($key)
    {
        return get_array_values($_SESSION,$key);
    }


}