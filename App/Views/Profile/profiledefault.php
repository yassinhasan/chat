<div class="profile-container container">
    <!-- basic Info -->
    <div class="card profile_card">
        <div class="profile-img">   
            <img src="<?= $this->getImage()?>" class="card-img-top img-thumbnail" alt="..." data-src="<?= PROFILE_URL?>">
        </div>
        
        <div class="card-body">
            <h5 class="card-title">Basic Info</h5>
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <span></span>
            </li>
            <li class="list-group-item profile_info"> 
                <div class="row">
                    <div class="first-col col">First name</div>
                    <div class="col card_info_firstName"><?=  $this->getFirstName()?></div>
                </div>
            </li>
            <li class="list-group-item profile_info"> 
                <div class="row">
                    <div class="first-col col">last name</div>
                    <div class="col card_info_lastName"><?= $this->getLastName() ?></div>
                </div>
            </li>
            <li class="list-group-item profile_info"> 
                <div class="row">
                    <div class="first-col col">address</div>
                    <div class="col card_info_address"><?= $this->getAddress() ?></div>
                </div>
            </li>
            <li class="list-group-item profile_info"> 
                <div class="row">
                    <div class="first-col col">date Of Birth</div>
                    <div class="col card_info_dateOfBirth"><?= $this->getDOB() ?></div>
                </div>
            </li>
            <li class="list-group-item profile_info"> 
                <div class="row">
                    <div class="first-col col"> gender </div>
                    <div class="col card_info_gender"><?= $this->getGender() ?></div>
                </div>
            </li>
        </ul>
        <div class="card-body">
            <a href="#profile_form" class="card-link edit_btn_profile">Edit Profile</a>
        </div>
    </div>
    <div class="card profile_form_wraper hidden">
        <!-- <img src="..." class="card-img-top" alt="..."> -->
        <div class="card-body">
            <h5 class="card-title">Edit Info</h5>
        </div>
        <form class="profile_form" enctype="multipart/form-data" id="profile_form">
                    <div class="profile-img">   
                        <img src="<?= $this->getImage()?>" class="card-img-top img-thumbnail edit" alt="..." data-src="<?= PROFILE_URL?>">
                        <input type="file" name="image" hidden class="profile_input">
                        <div class="invalid-feedback results image " role="alert" style="margin-top: 8px; padding: 4px;display:none"> </div>

                    </div>
                    <div class="row">
                            <div class="form-group col-12">
                                <label for="firstName"> first Name </label>
                                <input class="form-control form-control-sm" type="text" name="firstName" id="firstName" value="<?= $this->getFirstName() ?>">
                                <div class="invalid-feedback results firstName " role="alert" style="margin-top: 8px; padding: 4px;display:none">
                                </div>
                            </div>
                            <div class="form-group col-12">
                                <label for="lastName"> lastName  </label>
                                <input class="form-control form-control-sm"  type="text" name="lastName" id="lastName" value="<?= $this->getLastName() ?>">
                                <div class="invalid-feedback results lastName " role="alert" style="margin-top: 8px; padding: 4px;display:none">
                                </div>
                            </div>
                            <div class="form-group col-12">
                                <label for="address"> address  </label>
                                <input class="form-control form-control-sm"  type="text" name="address" id="address" value="<?= $this->getAddress() ?>">
                                <div class="invalid-feedback results address " role="alert" style="margin-top: 8px; padding: 4px;display:none">
                                </div>
                            </div>
                            <div class="form-group col-12">
                                <label for="dateOfBirth"> date Of Birth  </label>
                                <input class="form-control form-control-sm"  type="date" name="dateOfBirth" id="dateOfBirth" value="<?= $this->getDOB() ?>">
                                <div class="invalid-feedback results dateOfBirth " role="alert" style="margin-top: 8px; padding: 4px;display:none">
                                </div>
                            </div>                        </div>
                            <div class="form-group col-12">
                                <label> gender  </label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" id="male" value="male"
                                    <?= $this->isMale() ? "checked" : "" ?>
                                    >
                                    <label class="form-check-label" for="male">
                                    male
                                    </label>
                                </div>
                                <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender" id="female"
                                value="female"
                                <?= $this->isFemale() ? "checked" : "" ?>
                                >
                                <label class="form-check-label" for="female">
                                female
                                </label>
                                </div>
                                <div class="invalid-feedback results gender " role="alert" style="margin-top: 8px; padding: 4px;display:none">
                                </div>

                            </div>
                            <div class="form-group form-contact-save-btn">
                                <button type="button" class="btn btn-secondary cancel_Profile_Btn btn-sm" >Cancel</button>
                                <button type="button" class="btn btn-primary btn-sm save_profile" data-target="/chat/profile/saveBasicInfo/<?= $this->getuserId() ?>">Save Profile</button> 
                            </div>
                        

                    
        </form>
    </div>
   
   <!-- email -->
    <div class="card contact_card">
        <div class="card-body">
            <h5 class="card-title">Contant Info</h5>
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item contact_info"> 
                <div class="row">
                    <div class="first-col col">Email</div>
                    <div class="col card_info_email"><?=  $this->getEmail()?></div>
                </div>
                </li>
                <li class="list-group-item contact_info">
                <div class="row">
                    <div class="first-col col">Mobile number</div>
                    <div class="col card_info_mobile"><?=  $this->getMobile()?></div>
                </div>
            </li>
        </ul>
        <div class="card-body">
            <a href="#" class="card-link edit_btn_contact">Edit Contact Info</a>
        </div>
    </div>
    <div class="card contact_form_wraper hidden">
        <div class="card-body">
            <h5 class="card-title">Edit Contact Info</h5>
        </div>
        <form class="contact_form">
                    <div class="row">
                            <div class="form-group col-12">
                                <label for="email"> email </label>
                                <input class="form-control form-control-sm" type="email" name="email" id="email" value="<?= $this->getEmail() ?>">
                                <div class="invalid-feedback results email " role="alert" style="margin-top: 8px; padding: 4px;display:none">
                                </div>
                            </div>
                            <div class="form-group col-12">
                                <label for="mobile"> mobile </label>
                                <input class="form-control form-control-sm" type="tel" name="mobile" id="mobile" value="<?= $this->getMobile() ?>">
                                <div class="invalid-feedback results mobile " role="alert" style="margin-top: 8px; padding: 4px;display:none">
                                </div>
                            </div>
                            <div class="form-group form-contact-save-btn">
                                <button type="button" class="btn btn-secondary cancel_Btn_contact btn-sm" >Cancel</button>
                                <button type="button" class="btn btn-primary btn-sm save_Contact_Info" data-target="/chat/profile/saveContact/<?= $this->getuserId() ?>">Save Profile</button> 
                            </div>
                    </div>
        </form>
    </div>


   <!-- password -->
    <div class="card security_card">
        <!-- <img src="..." class="card-img-top" alt="..."> -->
        <div class="card-body">
            <h5 class="card-title">securoty Info</h5>
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <span></span>
            </li>
        </ul>
        <div class="card-body">
            <a href="#" class="card-link edit_btn_security">Change Password</a>
        </div>
    </div>
    <div class="card security_form_wraper hidden">
        <div class="card-body">
            <h5 class="card-title">Edit security Info</h5>
        </div>
        <form class="security_form">
                    <div class="row">
                            <div class="form-group col-12">
                                <label for="old Password">Old password </label>
                                <input class="form-control form-control-sm" type="password" name="oldPassword" id="oldPassword" value="">
                                <div class="invalid-feedback results oldPassword " role="alert" style="margin-top: 8px; padding: 4px;display:none">
                                </div>
                            </div>
                            <div class="form-group col-12">
                                <label for="newPassword"> new password </label>
                                <input class="form-control form-control-sm" type="password" name="newPassword" id="newPassword" value="">
                                <div class="invalid-feedback results newPassword " role="alert" style="margin-top: 8px; padding: 4px;display:none">
                                </div>
                            </div>
                            <div class="form-group col-12">
                                <label for="cNewPassword"> confirm new  password </label>
                                <input class="form-control form-control-sm" type="password" name="cNewPassword" value="">
                                <div class="invalid-feedback results cNewPassword" role="alert" style="margin-top: 8px; padding: 4px;display:none">
                                </div>
                            </div>
                            <div class="form-group form-contact-save-btn">
                                <button type="button" class="btn btn-secondary cancel_Btn_security btn-sm" >Cancel</button>
                                <button type="button" class="btn btn-primary btn-sm save_security" data-target="/chat/profile/editSecurity/<?= $this->getuserId() ?>">Save password</button> 
                            </div>
                    </div>
        </form>
    </div>

    <!-- edit password -->
</div>



