<div class="add-task">
    <button  class="btn btn-secondary add"
    type="button">Add privileges<i class="fas fa-plus"></i></button>
</div>
<div class="table-wraper">
    <table class="table table-bordered table-responsive text-center" id="table">
        
        <thead>
                <tr>
                    <th class="th-name">
                        Privileges Name
                    </th>
                    <th>
                    Privileges uRL
                    </th>
                    <th class="th-action">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody class="tbody">
            <?php

                foreach($privileges as $privilege)
                {
                    echo "<tr>"; ?>
                <td>
                <?=  $privilege->privilegesTilte ?>
                </td>
                <td>
                    <?=  $privilege->privilegesUrl ?>
                </td>
                <td class='action'>
                    <button data-href="/chat/privileges/edit/<?=$privilege->privilegesId ?>" class="btn btn-primary btn-sm edit "><i class="fas fa-edit"></i></button>
                    <button data-href="/chat/privileges/delete/<?=$privilege->privilegesId ?>" class="btn btn-danger btn-sm delete"><i class="fas fa-times"></i></button>
                </td>
                <?php  echo "</tr>";
                } 
            ?>
            </tbody>
    </table>
</div>



<div class="modal fade" tabindex="-1" id="addmodal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">add privilege</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form class="add-form">
                <div class="form-group">
                    <label for="privilegesTilte"> Privilege Title</label>
                    <input class="form-control" type="text" name="privilegesTilte" id="privilegesTilte">
                    <div class="invalid-feedback privilegesTilte" role="alert" style="margin-top: 8px; padding: 4px;display:none">
                    </div>
                </div>
                <div class="form-group" style="margin: 20px 0 0 0;">
                    <label for="privilegesUrl"> Privilege url</label>
                    <input class="form-control" type="text" name="privilegesUrl">
                    <div class="invalid-feedback privilegesUrl" role="alert" style="margin-top: 8px; padding: 4px;display:none">
                    </div>
                </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary save" data-target="/chat/privileges/add">Save Privileges</button>
      </div>
    </div>
  </div>
</div>






