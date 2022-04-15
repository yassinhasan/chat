<div class="modal fade" tabindex="-1" id="editmodal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">add privilege</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form class="edit-form">
                <div class="form-group">
                    <label for="groupName"> Privilege Title</label>
                    <input class="form-control" type="text" name="groupName" id="groupName" value="<?= isset($usersgroups->groupName) ? $usersgroups->groupName : "" ?>">
                    <div class="invalid-feedback groupName" role="alert" style="margin-top: 8px; padding: 4px;display:none">
                    </div>
                </div>
                <div class="form-group checkboxdiv">
                    <div class="form-group selectAllDiv">
                        <label for="selectAll" class="selectAllLabel"> selectAll</label>
                        <input class="form-check-input selectAllInput" type="checkbox"  id="selectAll" checked>
                    </div>
                <?php
                   
                    if(is_array($privileges) and !empty($privileges))
                    {
                      $privileges = array_chunk($privileges, 3);
                      
                      for($i = 0 ;  $i < count($privileges) ; $i++)
                        {
                           
                            echo "<div class='row' style='margin: 10px 0; padding-left: 0'>";
                                foreach($privileges[$i] as $privilege)
                                {  ?>
                                 
                                    
                                    <div class="col col-4">
                                        <div class="form-check all_check_inptus">
                                            <input class="form-check-input" type="checkbox" value="<?= isset($privilege->privilegesId) ? $privilege->privilegesId : null?>" id="label-<?= $privilege->privilegesId; ?>" name="privilegesId[]"
                                            <?= in_array($privilege->privilegesId , $selectedKeys) ? "checked = checked" : "" ?>
                                            >
                                            <label class="form-check-label" for="label-<?= $privilege->privilegesId; ?>">
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
        <button type="button" class="btn btn-primary update" data-target="/chat/usersgroups/update/<?= isset($usersgroups->groupId) ? $usersgroups->groupId : 0 ?>">Save usersgroups</button>
      </div>
    </div>
  </div>
</div>