<?php
namespace App\Controllers;


use App\Lib\filter;
use App\Lib\redirect;
use App\Lib\response;
use App\Lib\validate;
use App\Lib\encryptDecrypt;
use App\Models\UsersgroupsModel;
use App\Models\UsersModel;


class UsersController extends AbstractController 

{
    use redirect;
    use filter;
    use validate;
    use response;
    use encryptDecrypt;
    public function default()
    {    

        $this->lang->laod("users/usersdefault")->laod("common")->laod("errors");
        $this->template->addCss(toCss("users/users.css?122"))->addJs(toJs("users/users.js?12"));

        if($this->profile->isLogin())
        {
        $this->data['users'] =  UsersModel::getAllUserExceptLogin($this->profile->getuserId());            
        }


            // REMOVE IT and get it from query
        $this->data['groups'] = UsersgroupsModel::getAll(); 
        $this->_view();
    }
    public function valid($actionType = null,$id = null){
        $this->lang->laod("users/usersdefault")->laod("common")->laod("errors");
        if($actionType == "save")
        {
            return  $this->required("userName")->between("userName" , 4,20)->isString("userName")->exists(["userName", "app_users" , "userId" , $id])
            ->required("email")->isEmail("email")->exists(["email", "app_users" , "userId" , $id])
            ->required("mobile")->isInt("mobile")->min("mobile" , 10)
            ->required("groupId", "soory you must chosse at least one ")->isInt("groupId")
            ->isValid();    
        }
        else if($actionType == "activate"){
            return $this->required("activeCode")
                        ->isValid(); 
        }
        
        else{
            return  $this->required("userName")->between("userName" , 4,20)->isString("userName")->exists(["userName", "app_users"])
                    ->required("email")->isEmail("email")->exists(["email", "app_users"])
                    ->required("password")->between("password" , 4,20)->isString("password")
                    ->isMatched("cPassword" , "password" , "soory confirm password is not matched")
                    ->required("mobile")->isInt("mobile")->min("mobile" , 10)
                    ->required("groupId", "soory you must chosse at least one ")->isInt("groupId")
                    ->isValid();            
        }

    }
    public function add()
    {       
        if($_SERVER["REQUEST_METHOD"] !== "POST") {
             $this->redirect("/");
        } 
        if($this->valid())
        {   
            $userName = $this->filterString($_POST['userName']);
            $email = $this->filterString($_POST['email']);
            $password = $this->filterString($_POST['password']);
            $cPassword = $this->filterString($_POST['cPassword']);
            $mobile = $this->filterString($_POST['mobile']);
            $lastlogin = date("Y-m-d H:i:s",time()) ;
            $subscriptionDate = date("Y-m-d",time()) ;
            $groupId = $this->filterInt($_POST['groupId']);
            $verified = 1;
            $loginCode = $this->encrypt(time());


            $model = new UsersModel;
            $model->userName = $userName;
            $model->email = $email;
            $model->password = $this->encrypt($password);
            $model->mobile = $mobile;
            $model->lastlogin = $lastlogin;
            $model->subscriptionDate = $subscriptionDate;
            $model->groupId = $groupId;
            $model->verified = $verified;
            $model->loginCode = $loginCode;
         
             if($model->insert() > 0)
            { 
                $this->json['results'] = UsersModel::getAllUserExceptLogin($this->profile->getuserId());
                $this->json['suc'] = "suc";
                $this->json['redir'] = "/chat/users";

             }         
        }
        else
        {
         $this->json['err'] = $this->getMessage();
      
        }
       return $this->json($this->json);
       
    }
    // edit
    public function edit()
    {
       $id = $this->filterInt($this->params[0]);
       $this->data['user'] =  UsersModel::getByPk($id);
       $this->data['groups'] = UsersgroupsModel::getAll(); 
       echo $this->render("users/usersform.php", $this->data);
    }

    // update
    public function update()
    {
        if($_SERVER["REQUEST_METHOD"] !== "POST") {
            $this->redirect("/");
       }
       $id = $this->filterInt($this->params[0]);
       if(! $id > 0 ) return; 
       
       $userName = $this->filterString($_POST['userName']);
       $email = $this->filterString($_POST['email']);
       $mobile = $this->filterString($_POST['mobile']);
       $groupId = $this->filterInt($_POST['groupId']);
       $lastlogin = date("Y-m-d H:i:s",time()) ;

       
       if($this->valid("save" , $id))
       {   
            $model = UsersModel::getByPk($id);
            if( $model->data([
                "userName" => $userName,
                "email" => $email,
                "mobile" => $mobile,
                "lastlogin" => $lastlogin,
                "groupId" => $groupId,
            ])->where("userId = ?  " ,  $id )->updateData() >= 0)
            {
            $this->json['results'] = UsersModel::getAllUserExceptLogin($this->profile->getuserId());
            $this->json['suc'] = "Users updated successfully";
            $this->json['redir'] = "/chat/users";            
            }
      }
       else
       {
        $this->json['err'] = $this->getMessage();
     
       }
      return $this->json($this->json);

    }
    public function delete()
    {
        if($_SERVER["REQUEST_METHOD"] !== "POST") {
            $this->redirect("/");
       }
       $id = $this->filterInt($this->params[0]);
       if(! $id > 0 ) return;
          $model  = UsersModel::getByPk($id);
          if($model->delete($id) > 0)
          {
            $this->json['results'] = UsersModel::getAllUserExceptLogin($this->profile->getuserId());
            $this->json['suc'] = "users deleted successfully";
            $this->json['redir'] = "/chat/users";
          }          
       else
       {
        $this->json['err'] = " sorry error in delete ";
     
       }
      return $this->json($this->json);

    }

}
