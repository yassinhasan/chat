
<div class="add-task">
    <button  class="btn btn-secondary add"
    type="button">Add usersgroups <i class="fas fa-plus"></i></button>
</div>
<div class="table-wraper">
    <table class="table table-bordered table-responsive text-center" id="table">
        
        <thead>
                <tr>
                    <th class="th-name">
                        groupName 
                    </th>
                    <th class="th-action">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody class="tbody">
            <?php

                if(isset($usersgroups))
                {
                    if(is_array($usersgroups) and !empty($usersgroups))
                    {
                        foreach($usersgroups as $usersgroup)
                        {
                            echo "<tr>"; ?>
                        <td>
                        <?=  $usersgroup->groupName ?>
                        </td>
                        <td class='action'>
                            <button data-href="/chat/usersgroups/edit/<?=$usersgroup->groupId ?>" class="btn btn-primary btn-sm edit "><i class="fas fa-edit"></i></button>
                            <button data-href="/chat/usersgroups/delete/<?=$usersgroup->groupId ?>" class="btn btn-danger btn-sm delete"><i class="fas fa-times"></i></button>
                        </td>
                        <?php  echo "</tr>";
                        } 
                    }
                }
            ?>
            </tbody>
    </table>

</div>


<div class="modal fade" tabindex="-1" id="addmodal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">add usersgroups</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form class="add-form">
                <div class="form-group">
                    <label for="groupName"> group Name </label>
                    <input class="form-control" type="text" name="groupName" id="groupName">
                    <div class="invalid-feedback groupName" role="alert" style="margin-top: 8px; padding: 4px;display:none">
                    </div>
                </div>
                <div class="form-group checkboxdiv">
                    <div class="form-group selectAllDiv">
                        <label for="selectAllEdit" class="selectAllLabel"> selectAll</label>
                        <input class="form-check-input selectAllInput" type="checkbox"  id="selectAllEdit">
                    </div>
                <?php
                    if(is_array($privileges) and !empty($privileges))
                    {
                      $privileges = array_chunk($privileges, 3);
                      
                      for($i = 0 ;  $i < count($privileges) ; $i++)
                        {
                           
                            echo "<div class='row' style='margin: 10px 0; padding-left: 0'>";
                                foreach($privileges[$i] as $privilege)
                                { ?>
                                    <div class="col col-4">
                                        <div class="form-check all_check_inptus">
                                            <input class="form-check-input" type="checkbox" value="<?= isset($privilege->privilegesId) ? $privilege->privilegesId : null?>" id="<?= $privilege->privilegesTilte; ?>" name="privilegesId[]">
                                            <label class="form-check-label" for="<?= $privilege->privilegesTilte; ?>">
                                                <?= $privilege->privilegesTilte; ?>
                                            </label>
                                        </div>
                                    </div>
                                 <?php  
                                } 
  
                            echo "</div>";
                        }
                          
                    }
                ?>
                    <div class="invalid-feedback privilegesId" role="alert" style="margin-top: 8px; padding: 4px;display:none">
                    </div>
                </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary save" data-target="/chat/usersgroups/add">Save usersgroups</button>
      </div>
    </div>
  </div>
</div>






