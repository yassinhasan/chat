<?php
namespace App\Controllers;

use App\Lib\filter;
use App\Lib\redirect;
use App\Lib\response;
use App\Lib\validate;
use App\Models\PrivilegesModel;
use App\Models\UsersgroupsModel;
use App\Models\UsersgroupsprivilegesModel;

class UsersgroupsController extends AbstractController 

{
    use redirect;
    use filter;
    use validate;
    use response;
    public function default()
    {    

    
        $this->lang->laod("usersgroups/usersgroupsdefault")->laod("common");
        $this->template->addCss(toCss("usersgroups/usersgroups.css?1"))->addJs(toJs("usersgroups/usersgroups.js?11"));
        if(!$this->profile->isAdmin() )
        {

        $this->data['usersgroups'] = UsersgroupsModel::getBy(" * " , [ "groupId != " => $this->profile->getGroupId()] );            
        }else
        {
            $this->data['usersgroups'] = UsersgroupsModel::getBy(" * "  );  
        }

        $this->data['privileges'] = PrivilegesModel::getAll();
        $this->_view();
    }
    public function valid($id = null){

        
        $this->lang->laod("usersgroups/usersgroupsdefault")->laod("common")->laod("errors");
        if($id)
        {
            return  $this->required("groupName")->exists(["groupName", "app_users_groups" , "groupId" , $id])
            ->min("groupName" , 4)
            ->required("privilegesId", "soory you must chosse at least one ")
            ->isValid();           
        }
        return  $this->required("groupName")->exists(["groupName", "app_users_groups" ])
                    ->min("groupName" , 4)
                    ->required("privilegesId", "soory you must chosse at least one ")
                    ->isValid();
    }
    public function add()
    {       
        if($_SERVER["REQUEST_METHOD"] !== "POST") {
             $this->redirect("/");
        } 
        
        $groupName = $this->filterString($_POST['groupName']);
        if(!empty($_POST['privilegesId']) and is_array($_POST['privilegesId']))
        {
            $privilegesId = array_map( [$this , "filterInt"], $_POST['privilegesId'] ); 
        }
        if($this->valid())
        {   
           
             $model = new UsersgroupsModel;
             $model->groupName = $groupName;
             if($model->insert() > 0)
            { 
                     $lastId = $model->lastId();
                     foreach($privilegesId as $privilegeId)
                     {;
                         $groupdPrivilegesModel = new UsersgroupsprivilegesModel;
                         $groupdPrivilegesModel->groupId = $lastId ;
                         $groupdPrivilegesModel->privilegesId = $privilegeId;
                         if($groupdPrivilegesModel->insert() > 0)
                         {
                            $this->json['results'] = UsersgroupsModel::getAll();
                            $this->json['suc'] = "suc";
                            $this->json['redir'] = "/chat/usersgroups";
                         }
                     }
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
       $this->data['privileges'] = PrivilegesModel::getAll();
       $model =  UsersgroupsModel::getByPk($id);
       $this->data['usersgroups'] = $model;

       $selectedKeys = UsersgroupsprivilegesModel::getUserPrivilegesId($id);
       $this->data['selectedKeys'] = $selectedKeys;
       echo $this->render("usersgroups/usersgroupsform.php", $this->data);
    }

    // update
    public function update()
    {
        if($_SERVER["REQUEST_METHOD"] !== "POST") {
            $this->redirect("/");
       }
       $id = $this->filterInt($this->params[0]);
       if(! $id > 0 ) return; 
       
       $groupName = $this->filterString($_POST['groupName']);
     
       if($this->valid($id))
       {   
          $model =  UsersgroupsModel::getByPk($id);
          $model->groupName = $groupName;
          $model->update($id);

          $UsersgroupsprivilegesModel = new UsersgroupsprivilegesModel;
          $allPrivileges = $UsersgroupsprivilegesModel->query(" select privilegesId from app_groups_privileges  where groupId = ? " , $id)->fetchAll();
          foreach($allPrivileges as $key=> $value)
          {
              $oldPrivileges[] = $value->privilegesId;
          }
          if(!empty($_POST['privilegesId']) and is_array($_POST['privilegesId']))
          {
              $selectedprivilegesId = array_map( [$this , "filterInt"], $_POST['privilegesId'] ); 
          }
          // select
          $willAddedPrivileges = array_diff($selectedprivilegesId, $oldPrivileges);
          $willBeDeletedPrivileges = array_diff($oldPrivileges, $selectedprivilegesId);
          if(!empty($willBeDeletedPrivileges))
          {
              foreach($willBeDeletedPrivileges as $willBeDeletedPrivilege)
              {
                
                  $UsersgroupsprivilegesModel->query("delete from app_groups_privileges where privilegesId = ? " , $willBeDeletedPrivilege)->deleteData();
              }
          }
          if(!empty($willAddedPrivileges))
          {
              foreach($willAddedPrivileges as $willAddedPrivilege)
              {
                 $UsersgroupsprivilegesModel = new UsersgroupsprivilegesModel;
                  $UsersgroupsprivilegesModel->privilegesId = $willAddedPrivilege;
                  $UsersgroupsprivilegesModel->groupId = $id;
                  $UsersgroupsprivilegesModel->insert();
              }
          }
          $this->json['results'] = UsersgroupsModel::getAll();
          $this->json['suc'] = "Usersgroups updated successfully";
          $this->json['redir'] = "/chat/usersgroups";
         
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
       $groupdPrivilegesModel = new UsersgroupsprivilegesModel;
       $deletedPrivileges = $groupdPrivilegesModel->query("delete from app_groups_privileges where groupId = ?" , $id)->deleteData();
       if($deletedPrivileges)
       {
        
           $model = new UsersgroupsModel;
          if($model->delete($id) > 0)
          {
                  $this->json['results'] = UsersgroupsModel::getAll();
                  $this->json['suc'] = "usersgroups deleted successfully";
                  $this->json['redir'] = "/chat/usersgroups";
          }          
       }
      
       else
       {
        $this->json['err'] = " sorry error in delete ";
     
       }
      return $this->json($this->json);

    }
}
