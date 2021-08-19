<?php 
namespace App\Controllers;

use System\Controller;

class UserChatController extends Controller
{
    public function index($id)
    {

        $usermodel = $this->app->load->model("login");

        if($usermodel->isLoged())
        {
            $incoming_id = $id;
            $data['id'] = $incoming_id;
            $user = $this->app->db->from(' users ')->select(" * ")->where(["unique_id = ?" => $incoming_id])->fetch();
            if($user)
            {
                $data['user'] = $user; 
                $this->app->html->setTitle("user chat");
                $this->app->layout->loadLayout($this->app->view->render("userchat",$data)); 
            }
            else
            {
                header("location: /");
            }

        
        }
        else
        {
            header("location: /");
        }
    }

    public function submit($id)
    {
        $usermodel = $this->app->load->model("login");

        if($usermodel->isLoged())
        {
            $incoming_id = $id;
            $user = $this->app->db->from(' users ')->select(" * ")->where(["unique_id = ?" => $incoming_id])->fetch();
            if($user)
            {
                if($this->isValid())
                {
                // work here 
                 $messagemodel = $this->app->load->model("messages");
                if($messagemodel->insert($id))
                {
                    $this->json['success'] = 'messages send success';
                }
                 
                }
                

                return $this->json();
            }
            else
            {
                header("location: /");
            }

        
        }
        else
        {
            header("location: /");
        }

    }
    public function isValid()
    {
        $valid = $this->app->validator
        ->require('msg')
        ->valid();
        if( $valid == false)
        {
        $this->json['error'] = $this->app->validator->getErrorMessages();

        }
        return empty($this->json['error']);
    }

    public function keepactive($id)
    {
        
        $time = time();  
        $usermodel = $this->app->load->model("login");
        if($usermodel->isLoged())
        {
            $user = $usermodel->user();
            $this->app->db->data(" logintime = $time ")->where(["logincode = ?" => $user->logincode])->update('users');

            $incoming_id = $id;
            $user = $this->app->db->from(' users ')->select(" * ")->where(["unique_id = ?" => $incoming_id])->fetch();
            if($user)
            {
                $this->json['user'] = $user; 
                return $this->json();
            }
            
        }
    }

    public function keepmessageactive($id)
    {
        $incoming_id = $id;        
        //

        $user = $this->app->db->from(' users ')->select(" * ")->where(["unique_id = ?" => $incoming_id])->fetch();
        if($user)
        {
            $this->json['user'] = $user; 
        }
        //

        $this->json['tochat'] = toChat("uploades/images/");
        $this->json['incoming_id'] = $incoming_id;

        $outgoing_id = $this->app->session->get("outgoing_id");
        $this->json['outgoing_id'] = $outgoing_id;
        $messagemodel = $this->app->load->model("messages");
        $messages =  $messagemodel->getMessage($outgoing_id,$incoming_id);
        if($messages)
        {
            $this->json['messages'] = $messages;
        }
        else{
            $this->json['nomessages'] = "no messages yet";
        }
        return $this->json();


    }
}

