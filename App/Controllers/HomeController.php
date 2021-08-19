<?php 
namespace App\Controllers;

use System\Controller;

class HomeController extends Controller
{
    public function index()
    {

        $usermodel = $this->app->load->model("login");

        if($usermodel->isLoged())
        {
            $user = $usermodel->user();
            $users = $usermodel->getAllExceptLoginUser($user->id);
            $this->json['users'] = $users;
            
        }else
        {
            header("location: /login");
        }
        $data['user'] = $user;
        $data['users'] = $users;
        $this->app->html->setTitle("chat");
        $this->app->layout->loadLayout($this->app->view->render("chat",$data));
        
    }

    public function getAllUser()
    {
        $time = time();  
        $usermodel = $this->app->load->model("login");
        if($usermodel->isLoged())
        {
            $user = $usermodel->user();
            $this->app->db->data("status = 'active' , logintime = $time ")->where(["logincode = ?" => $user->logincode])->update('users');
            $users = $usermodel->getAllExceptLoginUser($user->unique_id);

            if($users != null)
            {

                $this->json['users'] = $users; 
                // $latestmessages = [];
                foreach($users as $singleuser)
                {
    
                     $messsages = $this->app->db->select(" * ")
                     ->from(" messages ")
                     ->where("  messages.incoming_id = $singleuser->unique_id  AND messages.outgoing_id = $user->unique_id
                                OR 
                                messages.incoming_id = $user->unique_id  AND messages.outgoing_id = $singleuser->unique_id
                     ")->limit(" 1 ")->order(" id DESC ")->fetch();
                    
                    if($messsages)
                    {


                        if($messsages->outgoing_id ==  $user->unique_id)
                        {
                            $singleuser->msg = "YOU : ".$messsages->msg; 
                        }
                        else
                        {
                            $singleuser->msg = $messsages->msg;
                        } 
                    }
                    else
                    {
                        $singleuser->msg = "sorry no messages exists"; 
                    }
                  
                }
                
            }
            else
            {
                $this->json['error'] = 'no user found'; 
            }

            
        }
        return $this->json();
    }

    public function search()
    {
        $usermodel = $this->app->load->model("login");
        $search =  $this->app->request->post('search'); 
        if($usermodel->isLoged())
        {
            $user = $usermodel->user();
            $users = $this->app->db->select("*")->from('users')->where("id != $user->id AND (firstname LIKE '%$search%' OR lastname LIKE '%$search%')")->fetchAll();
            $this->json['users'] = $users;   
                
        }
        return $this->json();
    }
    public function end()
    {
        if($this->app->session->has("loginkey"))
        {
         $logincode = $this->app->session->get("loginkey");   
         $this->app->db->data("status = 'offline'")->where(["logincode = ?" => $logincode])->update('users');
         $this->json['suc'] = 'yes';
        }
        
        return $this->json();
    }
}