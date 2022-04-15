<?php
namespace App\Lib;

use App\Models\ChatUsersModel;
use App\Models\ProfileModel;
use App\Models\UsersModel;

class profile 
{
    private $user;
    private  myCustomSessionHandler $session;
    private $messenger;
    public function __construct(register $register){
        $this->session = $register->session;
        $this->user  = $this->session->user;
        $this->setUserProfile();
        $this->messenger =  $register->messenger;
        $this->lang = $register->lang;   
    }

    public function setUserProfile()
    {
        if($this->isLogin())
        {
            $user = $this->getUser();
            $profileInfo = ProfileModel::getBy( " * " , [" userId = " , $user->userId]);
            if(false !== $profileInfo)
            {
                $this->user->profile =array_shift( $profileInfo);
            }
            $chatInfo = ChatUsersModel::getBy( " * " , [" userId = " , $user->userId]);
            if(false !== $chatInfo)
            {
                $this->user->chatInfo =array_shift( $chatInfo);
            }   
        }
    }

    //get info from chat info modeel
    public function getStatus()
    {
        return isset($this->user->chatInfo) ? $this->user->chatInfo->status : "";
    }
    public function getToken()
    {
        return isset($this->user->chatInfo) ? $this->user->chatInfo->token : null;
    }
    public function getConnectionId()
    {
        return isset($this->user->chatInfo) ? $this->user->chatInfo->connectionId : null;
    }

    public function hasProfile()
    {
        return isset( $this->user->profile);
    }
    public function getProfile()
    {
        if($this->hasProfile())
        {
            return $this->user->profile;
        }  else
        {
            return null;
        }
    }


    public function isLogin()
    {
        return $this->user !== false;
    }
    public function getName()
    {
       return $this->user->profile->firstName == null || $this->user->profile->lastName == null ? $this->user->userName : $this->user->profile->firstName." ".$this->user->profile->lastName;
    }
    public function hasImage()
    {
        if($this->hasProfile())
        {
            return  $this->user->profile->image != null;
        }else
        {
            return false;
        }
    }
    public function getImage()
    {
        return $this->hasImage() ? toPublicProfile($this->user->profile->image): toPublicProfile("avatar.jpeg");
    }
    public function getEmail()
    {
       return isset($this->user->email) ? $this->user->email : " not set ";
    }
    public function getMobile()
    {
       return isset($this->user->mobile) ? $this->user->mobile : " not set ";
    }
    public function getFirstName()
    {
        return isset($this->user->profile) ? $this->user->profile->firstName : null;
    }
    public function getLastName()
    {
        return isset($this->user->profile) ? $this->user->profile->lastName : null;
    }
    public function getAddress()
    {
        return isset($this->user->profile) ? $this->user->profile->address : null;
    }
    public function getDOB()
    {
        return isset($this->user->profile) ? $this->user->profile->dateOfBirth : null;
    }
    public function getGender()
    {
        return isset($this->user->profile) ? $this->user->profile->gender : null;
    }

    public function isMale()
    {
        if(isset($this->user->profile) )
        {
            if( $this->user->profile->gender == "male") return true;
        }else {
            return false;
        }

    }
    public function isFemale()
    {
        if(isset($this->user->profile) )
        {
            if( $this->user->profile->gender == "female") return true;
        }else {
            return false;
        }

    }
    public function getPrivileges()
    {
       return isset($this->user->privilegesUrl) ? explode(",",$this->user->privilegesUrl) : false;
    }
    public function getUser()
    {
        
      return $this->user;
    }
    public function getGroupId()
    {
        return isset($this->user->groupId) ? $this->user->groupId : false;
    }
    public function getuserId()
    {
        return isset($this->user->userId) ? $this->user->userId : false;
    }
    public function getactivationCode()
    {
        return isset($this->user->activationCode) ? $this->user->activationCode : false;
    }

    public function isAdmin()
    {
        $groupId=  $this->getGroupId();
        return ($groupId == 1) ? true : false;
    }
    public function isNotactive()
    {
        if($this->isLogin())
        {
            if($this->user->verified == 0)
            {
                $this->lang->laod("common");
                $this->messenger->addMessage($this->lang->getKey("activem_text_message") , $this->messenger::WARNING_MESSAGE);
                $messages = $this->messenger->getMessages();
                if(!empty($messages))
                {
                    foreach($messages as $message)
                    { ?>
                
                <div class="alert alert-<?= $message[1];?> alert-dismissible fade show activate-warning" role="alert">
                        <strong><?=$this->lang->getKey("activem_text_label") ?></strong>  <?= $message[0] ?>
                        <a href="#" style="color: #333;" class="activePorfile" data-bs-toggle="modal" data-bs-target="#activatemodal" type="button"><?=$this->lang->getKey("activem_text_href") ?></a>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                <?php }
                }
            }            
        }

    }
    public function isActive()
    {
        if($this->isLogin())
        {
            return $this->user->verified != 0    ;       
        }

    }

}