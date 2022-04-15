<?php
namespace App\Controllers;

use App\Lib\filter;
use App\Lib\Messenger;
use App\Lib\redirect;
use App\Lib\response;
use App\Lib\validate;
use App\Models\PrivilegesModel;
use App\Dtabase\Models\AbastractModel;
class PrivilegesController extends AbstractController 

{
    use redirect;
    use filter;
    use validate;
    use response;
    public function default()
    {  
        
        $this->lang->laod("privileges/privilegesdefault")->laod("common")->laod("errors");
        $this->template->addCss(toCss("privileges/privileges.css?1"))->addJs(toJs("privileges/privileges.js?111"));
        $this->data['privileges'] = PrivilegesModel::getAll();
        $this->_view();
    }
    public function add()
    {       
        if($_SERVER["REQUEST_METHOD"] !== "POST") {
             $this->redirect("/");
        } 
        $this->lang->laod("privileges/privilegesdefault")->laod("common")->laod("errors");
        $privilegesTilte = $this->filterString($_POST['privilegesTilte']);
        $privilegesUrl = $this->filterString($_POST['privilegesUrl']);
        if($this->valid())
        {   

             $model = new PrivilegesModel;
             $model->privilegesTilte = $privilegesTilte;
             $model->privilegesUrl = $privilegesUrl;
             if($model->insert() > 0)
             {
                 $this->json['results'] = PrivilegesModel::getAll();
                 $this->json['suc'] = "suc";
                 $this->json['redir'] = "/chat/privileges";
             }         
        }
        else
        {
         $this->json['err'] = $this->getMessage();
      
        }
       return $this->json($this->json);
       
    }
    public function valid(){

        return  $this->required("privilegesTilte")
                    ->min("privilegesTilte" , 4)
                    ->required("privilegesUrl")
                    ->isValid();
    }

    // edit
    public function edit()
    {
        $this->lang->laod("privileges/privilegesdefault")->laod("common")->laod("errors");
       $id = $this->filterInt($this->params[0]);
       $model =  PrivilegesModel::getByPk($id);
       $this->data['privilege'] = $model;
       echo $this->render("privileges/privilegesform.php", $this->data);
    }

    // update
    public function update()
    {
        $this->lang->laod("privileges/privilegesdefault")->laod("common")->laod("errors");
        if($_SERVER["REQUEST_METHOD"] !== "POST") {
            $this->redirect("/");
       }
       $id = $this->filterInt($this->params[0]);
       if(! $id > 0 ) return; 
       
       $privilegesTilte = $this->filterString($_POST['privilegesTilte']);
       $privilegesUrl = $this->filterString($_POST['privilegesUrl']);
       if($this->valid())
       {   
            $model = PrivilegesModel::getByPk($id);
            $model->privilegesTilte = $privilegesTilte;
            $model->privilegesUrl = $privilegesUrl;
            if($model->update($id) > 0)
            {
                $this->json['results'] = PrivilegesModel::getAll();
                $this->json['suc'] = "privileges updated successfully";
                $this->json['redir'] = "/chat/privileges";
            }else
            {
                 $this->json['results'] = PrivilegesModel::getAll();
                $this->json['suc'] = "no updates happened";
                $this->json['redir'] = "/chat/privileges";
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
       $this->lang->laod("privileges/privilegesdefault")->laod("common")->laod("errors");
       $id = $this->filterInt($this->params[0]);
       if(! $id > 0 ) return; 
       $model = new PrivilegesModel;
        if($model->delete($id) > 0)
        {
                $this->json['results'] = PrivilegesModel::getAll();
                $this->json['suc'] = "privileges deleted successfully";
                $this->json['redir'] = "/chat/privileges";
        }       
       else
       {
        $this->json['err'] = $this->getMessage();
     
       }
      return $this->json($this->json);

    }
}