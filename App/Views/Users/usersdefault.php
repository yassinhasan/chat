<div class="add-task">
    <button  class="btn btn-secondary add"
    type="button">Add User<i class="fas fa-plus"></i></button>
</div>
<div class="table-wraper">
    <table class="table table-bordered table-responsive text-center" id="table">
        
        <thead>
                <tr>
                    <th class="th-name">
                    user Name
                    </th>
                    <th>
                    email
                    </th>
                    <th>
                    mobile
                    </th>
                    <th>
                    last loginl
                    </th>
                    <th>
                    subscription Date
                    </th>
                    <th>
                    group
                    </th>
                    <th class="th-action">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody class="tbody">
            <?php
                if(!empty($users))
                {
                    foreach($users as $user)
                    {
                        echo "<tr>"; ?>
                    <td>
                    <?=  $user->userName ?>
                    </td>
                    <td>
                    <?=  $user->email ?>
                    </td>
                    <td>
                    <?=  $user->mobile ?>
                    </td>
                    <td>
                    <?=  $user->lastLogin ?>
                    </td>
                    <td>
                    <?=  $user->subscriptionDate ?>
                    </td>
                    <td>
                    <?=  $user->groupName ?>
                    </td>

                    <td class='action'>
                        <button data-href="/chat/users/edit/<?=$user->userId ?>" class="btn btn-primary btn-sm edit" style="margin-bottom: 3px;"><i class="fas fa-edit"></i></button>
                        <button data-href="/chat/users/delete/<?=$user->userId ?>" class="btn btn-danger btn-sm delete"><i class="fas fa-times"></i></button>
                    </td>
                    <?php  echo "</tr>";
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
        <h5 class="modal-title">add user</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form class="add-form">
            <div class="row">
                    <div class="form-group col-12">
                        <label for="userName"> User Name </label>
                        <input class="form-control form-control-sm" type="text" name="userName" id="userName">
                        <div class="invalid-feedback userName " role="alert" style="margin-top: 8px; padding: 4px;display:none">
                        </div>
                    </div>
                    <div class="form-group col-12">
                        <label for="email"> Email  </label>
                        <input class="form-control form-control-sm"  type="text" name="email" id="email">
                        <div class="invalid-feedback email " role="alert" style="margin-top: 8px; padding: 4px;display:none">
                        </div>
                    </div>
                    <div class="form-group col-12">
                        <label for="password"> password  </label>
                        <input class="form-control form-control-sm"  type="password" name="password" id="password">
                        <div class="invalid-feedback password " role="alert" style="margin-top: 8px; padding: 4px;display:none">
                        </div>
                    </div>
                    <div class="form-group col-12">
                        <label for="cPassword"> confirm password  </label>
                        <input class="form-control form-control-sm"  type="password" name="cPassword" id="cPassword">
                        <div class="invalid-feedback cPassword " role="alert" style="margin-top: 8px; padding: 4px;display:none">
                        </div>
                    </div>
                    <div class="form-group col-12">
                        <label for="mobile">  Mobile  </label>
                        <input class="form-control form-control-sm"  type="text" name="mobile" id="mobile">
                        <div class="invalid-feedback mobile " role="alert" style="margin-top: 8px; padding: 4px;display:none">
                        </div>
                    </div>
                    <div class="form-group" style="margin-top:8px;">
                        <select class="form-control form-control-md" name="groupId">
                            <option value=''> please choose group type</option>
                            <?php 
                            if(!empty($groups)):
                                foreach($groups as $group):
                                   echo  "<option value='".$group->groupId."'>".$group->groupName."</option>";
                                endforeach;
                             endif;
                            ?>

                        </select>
                        <div class="invalid-feedback groupId " role="alert" style="margin-top: 8px; padding: 4px;display:none">
                        </div>
                    </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary save" data-target="/chat/users/add">Save Users</button>
      </div>
    </div>
  </div>
</div>






