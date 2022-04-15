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
                    <label for="privilegesTilte"> Privilege Title</label>
                    <input class="form-control" type="text" name="privilegesTilte" id="privilegesTilte" value="<?= isset($privilege->privilegesTilte) ? $privilege->privilegesTilte : "" ?>">
                    <div class="invalid-feedback privilegesTilte" role="alert" style="margin-top: 8px; padding: 4px;display:none">
                    </div>
                </div>
                <div class="form-group" style="margin: 20px 0 0 0;">
                    <label for="privilegesUrl"> Privilege url</label>
                    <input class="form-control" type="text" name="privilegesUrl" value="<?= isset($privilege->privilegesUrl) ? $privilege->privilegesUrl : "" ?>">
                    <div class="invalid-feedback privilegesUrl" role="alert" style="margin-top: 8px; padding: 4px;display:none">
                    </div>
                </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary update" data-target="/chat/privileges/update/<?= isset($privilege->privilegesId) ? $privilege->privilegesId : 0 ?>">Save Privileges</button>
      </div>
    </div>
  </div>
</div>