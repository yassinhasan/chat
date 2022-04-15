<div class="modal fade" tabindex="-1" id="editmodal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">edit user</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form class="edit-form">
            <div class="row">
                    <div class="form-group col-12">
                        <label for="userName"> User Name </label>
                        <input class="form-control form-control-sm" type="text" name="userName" id="userName" value="<?= isset($user->userName) ? $user->userName : "" ?>">
                        <div class="invalid-feedback userName " role="alert" style="margin-top: 8px; padding: 4px;display:none">
                        </div>
                    </div>
                    <div class="form-group col-12">
                        <label for="email"> Email  </label>
                        <input class="form-control form-control-sm"  type="text" name="email" id="email" value="<?= isset($user->email) ? $user->email : "" ?>">
                        <div class="invalid-feedback email " role="alert" style="margin-top: 8px; padding: 4px;display:none">
                        </div>
                    </div>
                    <div class="form-group col-12">
                        <label for="mobile">  Mobile  </label>
                        <input class="form-control form-control-sm"  type="text" name="mobile" id="mobile" value="<?= isset($user->mobile) ? $user->mobile : "" ?>">
                        <div class="invalid-feedback mobile " role="alert" style="margin-top: 8px; padding: 4px;display:none">
                        </div>
                    </div>
                    <div class="form-group" style="margin-top:8px;">
                        <select class="form-control form-control-md" name="groupId">
                            <option value=''> please choose group type</option>
                            <?php 
                            if(!empty($groups)):
                                foreach($groups as $group): ?>
                                   <option value="<?= $group->groupId ?>"  <?= $group->groupId == $user->groupId ? 'selected' : '' ?> > <?= $group->groupName ?></option>
                              <?php  endforeach;
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
        <button type="button" class="btn btn-primary update" data-target="/chat/users/update/<?= isset($user->userId) ? $user->userId : 0 ?>">Save User</button>
      </div>
    </div>
  </div>
</div>