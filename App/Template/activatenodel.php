<div class="modal fade modal-xl" tabindex="-1" id="activatemodal" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-centered" >
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">activate account</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form class="activate-form">
                <div class="form-group">
                    <label for="activeCode" style="margin-bottom: 10px;">Enter Activation Code</label>
                    <input class="form-control form-control-lg" type="text" name="activeCode" id="activeCode" style="max-width: 200px;font-size: 30px;text-transform: uppercase">
                    <div class="invalid-feedback activeCode" role="alert" style="margin-top: 8px; padding: 4px;display:none">
                    </div>
                </div>
        </form>
      </div>
      <div class="modal-footer">
              <button type="button" class="btn btn-primary activateAcount" data-target="/chat/activate/activate">Activate</button>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

      </div>
    </div>
  </div>
</div>