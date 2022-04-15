<?php
namespace App\Lib;
class messenger 
{
    const SUCCESS_MESSAGE    = "success";
    const WARNING_MESSAGE    = "warning";
    const FAILED_MESSAGE     = "danger";
    const INFO_MESSAGE       = "info";
    private $messages;
    private  myCustomSessionHandler $session;

    public function __construct(register $register){

        $this->session = $register->session;
    }

    public function addMessage($message , $alert = self::SUCCESS_MESSAGE)
    {

        if(!$this->messageExists())
        {
           $this->session->message = [];
        }
        $msg = $this->session->message;
        $msg[] = [$message , $alert];
        $this->session->message  = $msg;
    }
    public function messageExists()
    {
        return isset($this->session->message);
    }
    public function getMessages()
    {
        if($this->messageExists())
        {
        $this->messages =  $this->session->message;
        unset($this->session->message);
        return $this->messages;            
        }

    }
}