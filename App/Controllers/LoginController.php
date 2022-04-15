<?php
namespace App\Controllers;
use App\Lib\filter;
use App\Lib\redirect;
use App\Lib\response;
use App\Lib\validate;
use App\Lib\encryptDecrypt;
use App\Models\ChatUsersModel;
use App\Models\ProfileModel;
use App\Models\UsersModel;
use PHPMailer\PHPMailer\PHPMailer;
class LoginController extends AbstractController
{
    use redirect;
    use filter;
    use validate;
    use response;
    use encryptDecrypt;
    public function default()
    {

        if($this->auth->isAutherised())
        {
            $this->redirect("/chat/home");
        }
        $this->lang->laod("login/logindefault")->laod("common");
        $this->template->addExclude(["nav","breadcrumb","wraperstart","wraperend", "footer"]);
        $this->template->addCss(toCss("login/login.css?15"))->addJs(toJs("login/login.js?44"));;
        $this->_view();
    }

    public function valid($register = false){

        if($register)
        {
            return  $this->required("userName")->between("userName" , 4,20)->isString("userName")->exists(["userName", "app_users"])
                        ->required("email")->isEmail("email")->exists(["email", "app_users"])
                        ->required("password")->between("password" , 4,20)->isString("password")
                        ->isMatched("cPassword" , "password" , "soory confirm password is not matched")
                        ->isValid();            
        }else
        {
        return  $this->required("email")->isEmail("email")
                    ->required("password")
                    ->isValid();             
        }

    }

    public function register()
    {       
        if($_SERVER["REQUEST_METHOD"] !== "POST") {
             $this->redirect("/");
        } 
        $this->lang->laod("users/usersdefault")->laod("common")->laod("errors");
        if($this->valid($register = true))
        {   
            $userName = $this->filterString($_POST['userName']);
            $email = $this->filterString($_POST['email']);
            $password = $this->filterString($_POST['password']);
            $cPassword = $this->filterString($_POST['cPassword']);
            $lastlogin = date("Y-m-d H:i:s",time()) ;
            $subscriptionDate = date("Y-m-d",time()) ;
            $groupId = 2;
            $verified = 0;
            $loginCode = $this->encrypt(time());
            $activationCode = sha1(uniqid("YA-"));
            $activationCode = strtoupper(substr($activationCode,0,8));

            $model = new UsersModel;
            if($model->data([
                "userName" => $userName , 
                "email" => $email,
                "password" => $this->encrypt($password),
                "lastlogin" => $lastlogin,
                "mobile"    => null , 
                "subscriptionDate" => $subscriptionDate,
                "groupId" => $groupId,
                "verified" => $verified,
                "loginCode " => $loginCode,
                "activationCode" =>  $activationCode
            ])->insertData())
            {
                $hashedUsername = $this->encrypt($userName);
                $this->session->loginCode =  $hashedUsername; 
                $this->json['suc'] = "wellcome  ".$userName;
                $this->json['redir'] = "https://port-3000-php-yassin-smsmhasan158145.preview.codeanywhere.com/chat/home";
           // send message if he is login 
            $this->emailMsg->sendMsg([
                "nameOfSender" => "Yassin",
                "nameOfReciever" => $userName,
                "from"  => "figo781@gmail.com" ,
                "to" =>  $email , 
                "subject" => "wellcome  ".$userName ,
                "body" => " <div> 
                                <h5 class='center'> wellcome  ".$userName."
                                </h5>
                            </div>
                            <p> your activation code is : <span style='color:red;font-size:20px'> $activationCode  </span>  </p>
                            "
            ]);  
            $lastId = $model->lastId();
            $token = substr(md5(uniqid()) ,16);
            $chatuserModel = new ChatUsersModel;
            $chatuserModel->data([
                "userId" => $lastId ,
                "token" => $token,
                "connectionId" => null ,
                "status"      => "login"


            ])->insertData();
            $profileModel = new ProfileModel;
            $profileModel->data([
                "userId" => $lastId 
            ])->insertData();
            }         
        }
        else
        {
         $this->json['err'] = $this->getMessage();
      
        }
       return $this->json($this->json);
       
    }

    public function authenticate()
    {       
        if($_SERVER["REQUEST_METHOD"] !== "POST") {
             $this->redirect("/chat/home");
        } 
        $this->lang->laod("common")->laod("errors");
        if($this->valid())
        {   
            $email = $this->filterString($_POST['email']);
            $password =$this->filterString($_POST['password']);
            $lastlogin = date("Y-m-d H:i:s",time()) ;
            $rememberMe = isset($_POST['rememberMe']) ? $this->filterString($_POST['rememberMe']) : null;


            $founduser = UsersModel::geBasicinformation("email" , $email);
            if($founduser !== false)
            {
                $founduser = $founduser[0];
               if( $password == $this->decrypt($founduser->password))
               {
                   if($founduser->status == 0)
                   {
                       $this->json['disabled'] = "sorry your are disabled";
                   }else
                   {
                       $hashedUsername = $this->encrypt($founduser->userName);
                        if($rememberMe and $rememberMe =="on")
                        {
                            
                            $this->cookie->setCookie("loginCode" ,  $hashedUsername);
                        }else
                        {
                              $this->session->loginCode =  $hashedUsername;                        
                        }
                        $founduser->data([
                            "lastLogin" => $lastlogin ,
                            "loginCode" =>  $hashedUsername
                        ])->where("userId =  ? " , $founduser->userId)->updateData(); 
                        ChatUsersModel::updateToLogin( "userId" , $founduser->userId );
                    $this->json['suc'] = " wellcome ".$founduser->userName;

                    $this->json['redir'] = "https://port-3000-php-yassin-smsmhasan158145.preview.codeanywhere.com/chat/";                       
                   }

                   
               }else
               {
                $this->json['failed'] = " sorry wrong password" ;
               }
            }else
            {
                $this->json['failed'] = "sorry no user with this email found" ;
            }   
        }
        else
        {
         $this->json['err'] = $this->getMessage();
      
        }
       return $this->json($this->json);
       
    }


}