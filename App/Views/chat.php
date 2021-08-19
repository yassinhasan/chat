<div class="wraper">
    <section>
        <header class="chat">
            <div class="info">
                <div>
                <img src="<?= toChat("uploades/images/$user->image") ?>">
                </div>
                <div class="info-items">
                    <p> <?= $user->firstname." ".$user->lastname ?></p>
                    <p> <?= $user->status ?></p>
                </div>
            </div>
            <a href="<?= toBase("logout")?>" class="logout"> logout</a>
        </header>
    </section>
    <!-- search section -->
    <div class="form-wraper">
        <form class="form"  method="post" action="<?=toBase("search") ?>">
                <div class="form-input search">
                    <input type="search" name="search" class="input search" placeholder=" Select User To Chat"> 
                    <i class="fas fa-search search-icon"></i>
                </div>
        </form>
    </div>
    <!-- load all users -->
    <div class="all-users">        
    </div>

</div>
<script src="<?= toChat("js/chat.js") ?>"></script>
