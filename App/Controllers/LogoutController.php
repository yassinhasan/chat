<?php
namespace App\Controllers;
use App\Lib\redirect;
use App\Models\ChatUsersModel;

class LogoutController extends AbstractController
{
    use redirect;
    public function default()
    {
        
        if(($this->session->user))
        {
            ChatUsersModel::updateToLogout( "userId" , $this->session->user->userId );
            $this->cookie->kill("loginCode");
            $this->session->kill();
        }
        $this->redirect("/chat/login");

    }
}