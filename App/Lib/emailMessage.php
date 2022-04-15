<?php
namespace App\Lib;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class emailMessage 
{
    private $email;
    private $error;
    public function __construct(register $register){
        $this->session = $register->session;
        $this->email = new PHPMailer();

    }
    public function sendMsg(array $input)
    {  
        $this->email->IsSMTP();  // telling the class to use SMTP
        $this->email->SMTPDebug = 0;
        $this->email->Mailer = "smtp";
        $this->email->SMTPSecure = 'ssl';
        $this->email->Host = "smtp.gmail.com";
        $this->email->Port = 465;
        $this->email->SMTPAuth = true; // turn on SMTP authentication
        $this->email->Username = "figo781@gmail.com";  
        $this->email->Password = "tulutvsnwjgfzezz";   
        $this->email->Priority = 1;
        $this->email->AddAddress($input["to"],$input["nameOfReciever"]);
        $this->email->SetFrom($input['from'], $input['nameOfSender']);
      //  $this->email->AddReplyTo($input['to'],"test");
        $this->email->Subject  = $input['subject'];
        $this->email->IsHTML(true);
        $this->email->Body     = $input["body"];
        $this->email->WordWrap = 50;
        if(!$this->email->Send()) {
        echo 'Message was not sent.';
        echo 'Mailer error: ' . $this->email->ErrorInfo;
        } else {
        // echo 'Message has been sent.';
        return true;
        }
    }
}