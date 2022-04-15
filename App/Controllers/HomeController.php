<?php
namespace App\Controllers;

use APP\Lib\encryptDecrypt;
use App\Lib\filter;
use App\Lib\redirect;
use App\Lib\response;
use App\Lib\validate;
use App\Models\ChatModel;
use App\Models\ChatUsersModel;

class HomeController extends AbstractController 
{
    use encryptDecrypt;
    use redirect;
    use response;
    use validate;
    use filter;
    public function default()
    {
        

        if(! $this->auth->isAutherised())
        {
            $this->redirect("/chat/login");
        }
        $this->lang->laod("home/homedefault")->laod("common");
        $this->template->addExclude(["nav","wraperstart","wraperend","footer"]);
        $this->template->addCss(toCss("home/home.css?dss2"));
        $this->template->addJs(toJs("home/home.js?d5s"));
        $this->data['logedUser'] = $this->profile->getProfile();
        $this->data['loadHeaderContactsExceptLogged'] = BASE_URL."home/loadHeaderContactsExceptLogged";
        $this->data['saveFiles'] = BASE_URL."home/saveFiles";
        $this->data['loadchat'] = BASE_URL."home/loadChatInPrivateChatArea";
        $this->data['saveChat'] = BASE_URL."home/saveChat";
        $this->data['loadAllexpcetlogged'] = BASE_URL."home/loadAllExceptLogged";
        $this->data['profilepath'] = PROFILE_URL;
        $this->data['app_chat_path'] = APP_CHAT_URL;

        $this->_view();
    } 

    public function loadHeaderContactsExceptLogged()
    {
        if($_SERVER["REQUEST_METHOD"] !== "POST") {
            $this->redirect("/chat/home");
       } 
       $this->lang->laod("common")->laod("errors");
       $fromId = $this->filterInt($_POST['loggeduser']);
       $this->json["allusers"] = ChatUsersModel::getAllUserExcpetLogin($fromId);
       return $this->json($this->json); 
    }
    public function saveFiles()
    {
        
        $fromId = $this->filterInt($_POST['fromId']);
        $toId = $this->filterInt($_POST['toId']);
        $msg = $this->filterString($_POST['msg']);
        if($this->validFile([true , $fromId, $toId]))
        {
            
            $file = $this->uploadfile->getFileSavedNameInDb();
            $attachment_type =$this->uploadfile->getfileExtension();
            $attachment_name =$this->uploadfile->getFileName();
            $has_attachment = $file == null ? 0 : 1;
            
            $chatmodel = new ChatModel();
            if(            $chatmodel->data([
                "fromId" => $fromId , 
                "toId"   => $toId , 
                "msg"    => $msg ,
                "created" => date("Y-m-d H:i:s" , time()) ,
                "attachment" => $file ,
                "attachment_type" => $attachment_type , 
                "attachment_name" => $attachment_name , 
                "has_attachment"  => $has_attachment ,
                "status"         => "unread"
            ])->insertData("app_chat"))
            {
                 $this->json['suc'] = "done";
                 $this->json['allmsg'] = ChatModel::getAllMsg($fromId,$toId);
            }else
            {
                $this->json['err_data'] = "err in save";
            }

           
        }else
        {
            $this->json['err'] = $this->getMessage();
        }
        return $this->json($this->json);
    }
    public function saveChat()
    {
        if($_SERVER["REQUEST_METHOD"] !== "POST") {
            $this->redirect("/chat/home");
       } 
       $this->lang->laod("common")->laod("errors");

       $msg = $this->filterString($_POST['msg']);
        $this->json["test"] = $msg;
        return $this->json($this->json);
    }
    public function loadChatInPrivateChatArea()
    {
        if($_SERVER["REQUEST_METHOD"] !== "POST") {
            $this->redirect("/chat/home");
       } 
       $this->lang->laod("common")->laod("errors");
       $fromId = $this->filterInt($_POST['fromId']);
       $toId = $this->filterInt($_POST['toId']);
       $this->json['allmsg'] = ChatModel::getAllMsg($fromId,$toId);
       ChatModel::updateUnreadMsfs($fromId , $toId);
       return $this->json($this->json);
    }

    public function valid(){

        return  $this->required("msg")->isString("msg")
                ->isValid();            
    }
    public function validFile($paramter)
    {
        return  $this->moveWithOutRequire("file" , $paramter , true)
        ->isValid();  
    }

    public function loadAllExceptLogged()
    {
        if($_SERVER["REQUEST_METHOD"] !== "POST") {
            $this->redirect("/chat/home");
       } 
       $this->lang->laod("common")->laod("errors");
       $logeduser = $this->filterInt($_POST['loggeduser']);
       $getAllUserExcpetLogin= ChatUsersModel::getAllUserExcpetLogin($logeduser);
       
       foreach( $getAllUserExcpetLogin as $user)
       { 
        $user->msg=  ChatModel::loadAllChat($user->userId , $logeduser); 
        if( $user->msg)
        {
            $user->modified = strtotime($user->msg->created) ;
        }else
        {
            $user->modified = rand(-1 , -10);
        }
        $all[] = $user;
       } 
       $this->json['getAllUserExcpetLogin'] = $all;
       $this->json['imagesrc'] = PROFILE_URL;
       return $this->json($this->json);
    }
}
