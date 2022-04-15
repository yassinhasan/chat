

<div class="container">
        <!-- wraper -->
        <div class="wraper-chat">
        <div class="inner-wraper">
                        <!-- header -->
            <div class="wraper-header" data-token="<?= $this->getToken() ?>" data-userId="<?=  $this->getuserId() ; ?>" data-loadchat="<?= $loadchat?>" data-profilepath="<?= $profilepath ?>" data-saveFiles="<?= $saveFiles ?>" data-app_chat_path="<?= $app_chat_path?>">
                <div class="header row" >
                        <div class="profile-pic-header col col-7">
                            <div class="profile-image-section">
                                <img src="<?= $this->getImage() ?>" alt="profile-pic" class="">
                                <i class="fas fa-circle <?= $this->getStatus() ?>"></i>
                                <span class="profile-name"> <?= $this->getName() ?>
                            </span>
                            </div>
                        </div>
                        <div class="profile-settings col col-5 text-end">
                            <ul style="list-style:none">
                                <li class="dropdwon">
                                    <a href="#" class="dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" >
                                        <i class="fas fa-cog dropdown"></i>                               
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="profileDropdown">
                                        <li>
                                            <a  class="dropdown-item" href="/chat/profile">
                                            Edit Profile 
                                            <i class="fas fa-edit"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a  class="dropdown-item logout-chat" data-href="/chat/logout">
                                            Logout 
                                            <i class="fas fa-lock"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>

                        </div>
                </div>
            </div>
            <div class="form-group wraper-search">
                <form>
                    <input class="form-control" type="text">
                    <i class="fas fa-search"></i>
                </form>
            </div>
            <div class="wraper-contacts" data-url="<?= $loadHeaderContactsExceptLogged?>">
            </div>
            <div class="wraper-chat-area" data-loadallaexcpetlogged="<?= $loadAllexpcetlogged ?>">
                <ul class="chat-area">
                </ul>
            </div>
        </div>
        <!-- start private -->
        <div class="private-wraper">
            <div class="inner-wraper-private">
                <div class="wraper-private-header">
                    <div class="private-header">
                    <div class="private-chat-info">
                          <span class="backtochat">
                              <i class="fas fa-arrow-left"></i>
                          </span>
                            <div class="reciever-info">
                                <img src="<?= toPublicProfile("164103161234c66477519b949b09b45e131347c17b5822a30a.jpeg") ?>" alt="profile-pic" class="">
                                <i class="fas fa-circle <?= $this->getStatus() ?>"></i>
                            </div>
                            <span class="chatname" style="margin-left: 7px;"></span>
                        </div>
                        <div>
                            <i class="fas fa-cog"></i>
                        </div>
                    </div>
                </div>
                <div class="private-chat-area">
                </div>
            </div>
        </div>
        <!-- end private -->
    </div>
    <div class="chat-footer">
        <div class="fotter-wraper row">
            <div class="col col-10">
                <span class="profile-name">
                    groups
                </span>
                 </div>
                 <div class="col col-1">
                <i class="fas fa-globe-europe"></i>
                 </div>
             </div>
    </div>
<div class="privatechat-footer">
        <form method="POST" class="chat-form" data-url="<?= $savechat ?>" enctype="multipart/form-data">
            <div class="form-group  msgarea-wraper row" style="margin: 0">
                    <div class="progress"><span></span></div>
                    <button class="btn btn-primary btn-sm upload">+</button>
                    <div class="msgarea" name="msg" contenteditable="true"></div>
                    <input type="file" hidden class="hidden-file" name="file">
                    <div class="send">
                     <button class="fas fa-reply sendchat" role="button"></button>
                    </div>
            </div>
        </form>
</div>

</div>


