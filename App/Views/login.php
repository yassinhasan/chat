<div class="wraper">
    <section>
        <header class="header">
            yassin family chat
        </header>
    </section>
    <div class="form-wraper">
        <div class="result"></div>
        <form class="form" enctype="multipart/form-data" method="post" action="<?=toBase("login/submit") ?>">
            <div class="form-box">
                <div class="form-input">
                    <label for="email">
                        email
                    </label>
                    <input type="email" name="email" class="input" id="email"> 
                </div>
                <div class="form-input">
                    <label for="password">
                        password
                    </label>
                    <input type="password" name="password" class="input" id="password"> 
                </div>
                <div class="form-submit">
                    <input type="submit" name="submit" class="submit" value="Continue To Chat"> 
                </div>
                <div class="form-signed">
                    <p> Not Yet Signed Up?  </p><a href="<?= toBase("signup")?>">  Sign Up Now </a>
                </div>
            </div>
        </form>
    </div>
</div>
<script src="<?= toChat("js/login.js") ?>"></script>
