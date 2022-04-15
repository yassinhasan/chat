<?php
namespace App\Controllers;


use App\Lib\filter;
use App\Lib\redirect;
use App\Lib\response;
use App\Lib\validate;
use App\Lib\encryptDecrypt;
use App\Models\UsersgroupsModel;
use App\Models\UsersModel;


class ActivateController extends AbstractController 

{
    use redirect;
    use filter;
    use validate;
    use response;
    use encryptDecrypt;

    public function valid(){

        return $this->required("activeCode")
                    ->isValid(); 
           
 
    }


    public function activate()
    {       
        if($_SERVER["REQUEST_METHOD"] !== "POST") {
             $this->redirect("/");
        } 
        $this->lang->laod("common")->laod("errors");
        if($this->valid())
        {   
            $activeCode =strtoupper( $this->filterString($_POST['activeCode']));

            if($this->profile->getactivationCode() == $activeCode)
            {   
                
                $userModel = new UsersModel;
                if($userModel->data([
                    " verified " => 1 ,
                    "activationCode" => null
                ])->where( " userId = ? " , $this->profile->getuserId())->updateData() >  0 )
                {
                    
                    $this->json['suc'] = "account updated successfully";
                }else
                {
                    $this->json['databaseerror'] = " error in update";
                }
            }else
            {
                $this->json['failed'] = " sorry activated code not matched";
            }        
        }
        else
        {
         $this->json['err'] = $this->getMessage();
      
        }

       return $this->json($this->json);
       
    }
}
