<?php
namespace Http;
class Request 
{

    private $url;
    private $baseurl;

    public function prepareUrl()
    {
      $url = $this->server("REQUEST_URI");
      $this->url = $url;

    }


    public function url()
    {
         return $this->url;
    }

    public function server($key)
    {
       return get_array_values($_SERVER,$key);
    }

    public function baseUrl()
    {
      $baseurl = $this->server("REQUEST_SCHEME")."://".$this->server("HTTP_HOST")."/";
      $this->baseurl = $baseurl;
      return $this->baseurl;
    }

    public function file($key)
    {
       return get_array_values($_FILES,$key);
    }
    public function post($key)
    {
       return get_array_values($_POST,$key);
    }
    public function get($key)
    {
       return get_array_values($_GET,$key);
    }
    public function redirectTo($direction)
    {
       if($direction != "/")
       {
          $direction = $this->baseUrl().$direction;
       }
       else
       {
         $direction = $this->baseUrl();
       }
      
        header("location: $direction");
    }
}