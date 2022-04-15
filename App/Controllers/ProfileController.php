<?php
namespace App\Controllers;
use App\Models\ProfileModel;
use App\Lib\filter;
use App\Lib\response;
use App\Lib\redirect;
use App\Lib\validate;
use App\Lib\uploadFile;
use App\Models\UsersModel;


class ProfileController extends AbstractController 
{
    use filter;
    use validate;
    use response;
    use redirect;
    public function default()
    {
        $this->lang->laod("profile/profiledefault")->laod("common");
        $this->template->addCss(toCss("profile/profile.css?4"));
        $this->template->addJs(toJs("profile/profile.js?03"));
        $this->_view();
    }

    public function valid($actionType = null,$id = null){
        $this->lang->laod("profile/profiledefault")->laod("common")->laod("errors");

        if($actionType == "saveBasicInfo")
        {
            return  $this->required("firstName")->between("firstName" , 2,20)->isString("firstName")
            ->moveWithOutRequire("image")
            ->required("lastName")->isString("lastName")->between("lastName" , 2,20)
            ->between("address" , 2 ,20 )->isString("address")
            ->required("dateOfBirth")
            ->required("gender")->isString("gender")
            ->isValid();    
        }else if($actionType == "saveContact")
        {
            return  $this->required("email")->isEmail("email")->exists(["email", "app_users" , "userId" , $id])
            ->required("mobile")->isInt("mobile")->min("mobile" , 10)
            ->isValid(); 
        }else if($actionType == "checkOldPassword")
        {
            return  $this->required("oldPassword")->matchOldPassword(["oldPassword" , $id])
            ->isValid(); 
        }else if($actionType = "saveSecurity")
        {
            return  $this->required("newPassword")->between("newPassword" , 4,20)->isString("newPassword")
            ->isMatched("cNewPassword" , "newPassword" , "soory confirm password is not matched")
            ->isValid(); 
        }

    }
    public function saveBasicInfo()
    {
        if($_SERVER["REQUEST_METHOD"] !== "POST") {
            $this->redirect("/");
       }
       $id = $this->filterInt($this->params[0]);
       if(! $id > 0 ) return; 
       $userId = $this->filterInt($id);
       $firstName = $this->filterString($_POST['firstName']);
       $lastName = $this->filterString($_POST['lastName']);
       $address = $this->filterString($_POST['address']);
       $gender = $this->filterString($_POST['gender']);
       $dateOfBirth = $this->filterString($_POST['dateOfBirth']);
       if($this->valid("saveBasicInfo" , $id))
       { 
           $image = $this->uploadfile->getFileSavedNameInDb();
           $isCreatedProfile = ProfileModel::getBy(" * " , [" userId  = " , $id]);
           if(false == $isCreatedProfile)
            {
                // insert here
                $model = new ProfileModel;
                if( $model->data([
                    "userId" => $userId,
                    "firstName" => $firstName,
                    "lastName" => $lastName,
                    "address" => $address,
                    "gender" => $gender,
                    "dateOfBirth" => $dateOfBirth,
                    "image"       => $image
                ])->insertData() >= 0)
                {
                    $this->json['suc'] = "Users inserted successfully";        
                }

            }else
            {   
                $profile = array_shift($isCreatedProfile);
                // updated
                
                if( $profile->data([
                    "firstName" => $firstName,
                    "lastName" => $lastName,
                    "address" => $address,
                    "gender" => $gender,
                    "dateOfBirth" => $dateOfBirth,
                    "image"       => $image
                ])->where("userId = ?  " ,  $id )->updateData() >= 0)
                {
                     $this->json['suc'] = "Users updated successfully";
                      
                }
            }
            $profile  = ProfileModel::getBy(" firstName , lastName ,  address , gender , dateOfBirth , image " , [" userId  = " , $id]);  
            $profile = array_shift($profile);
            $this->json['updated']  = $profile;

      }
       else
       {
        $this->json['err'] = $this->getMessage();
     
       }
      return $this->json($this->json);

    }  

    public function saveContact()
    {
        if($_SERVER["REQUEST_METHOD"] !== "POST") {
            $this->redirect("/");
       }
       $id = $this->filterInt($this->params[0]);
       if(! $id > 0 ) return; 
       
       $email = $this->filterString($_POST['email']);
       $mobile = $this->filterString($_POST['mobile']);
       if($this->valid("saveContact" , $id))
       {   
            $model = UsersModel::getByPk($id);
            if( $model->data([
                "email" => $email,
                "mobile" => $mobile,
            ])->where("userId = ?  " ,  $id )->updateData() >= 0)
            {
            $ContaciInfo  = UsersModel::getBy(" email , mobile " , [" userId  = " , $id]);  
            $ContaciInfo = array_shift($ContaciInfo);
            $this->json['updated']  = $ContaciInfo;    
            $this->json['suc'] = "Contact info  updated successfully";         
            }
      }
       else
       {
        $this->json['err'] = $this->getMessage();
     
       }
      return $this->json($this->json);

    }
    public function editSecurity()
    {
        if($_SERVER["REQUEST_METHOD"] !== "POST") {
            $this->redirect("/");
       }
       $id = $this->filterInt($this->params[0]);
       if(! $id > 0 ) return; 
       $oldPassword = $this->filterString($_POST['oldPassword']);
       $newPassword = $this->filterString($_POST['newPassword']);
       $encryptedPassword = $this->encrypt($newPassword);
       $cNewPassword = $this->filterString($_POST['cNewPassword']);
       if(!$this->valid("checkOldPassword" , $id))
       { 
        $this->json['err'] = $this->getMessage();
       }
       else
       {
            if($this->valid("saveSecurity"))
            {
                // here update
   
                $userModel = new UsersModel;
                if( $userModel->data([
                    "password" => $encryptedPassword
                ])->where("userId = ?  " ,  $id )->updateData() >= 0)
                {
                     $this->json['suc'] = " password updated successfully";
                      
                }

            }else
            {
                $this->json['err'] = $this->getMessage();
            }
     
       }
      return $this->json($this->json);
    }
}
