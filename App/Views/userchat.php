<div class="wraper">
    <section>
        <header class="chat">
            <div class="info" data-target="<?=toBase("userchat/keepactive/$id") ?>">
                <a href="/"><i class="fas fa-arrow-left arrow-icon"></i></a>
                <div>
                <img src="<?= toChat("uploades/images/$user->image") ?>">
                </div>
                <div class="info-items">
                    <p> <?= $user->firstname." ".$user->lastname ?></p>
                    <p class='status'></p>
                </div>
            </div>
        </header>
    </section>

    <!-- load all users -->
    <div class="chat-area" data-target="<?=toBase("userchat/keepmessageactive/$id") ?>">
    </div>
    <!-- send chat -->
    <div class="form-wraper userchat">
        <form class="form" enctype="multipart/form-data" method="post" action="<?=toBase("userchat/submit/$id") ?>">
                <div class="form-input search">
                    <textarea name="msg" class="textarea-msg"></textarea>
                    <button class="button-msg"><i class="fas fa-paper-plane icon-msg"></i></button>
                </div>
        </form>
    </div>

</div>
<script src="<?= toChat("js/userchat.js") ?>"></script>
