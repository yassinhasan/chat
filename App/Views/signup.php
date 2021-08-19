<div class="wraper">
    <section>
    <header class="header">
            yassin family chat
        </header>
        <div class="form-wraper">
             <div class="result"></div>
            <form class="form" enctype="multipart/form-data" method="post" action="<?=toBase("signup/submit") ?>">
                <div class="form-box">
                    <div class="form-group">
                        <div class="form-input">
                            <label for="firstname">
                                first name
                            </label>
                            <input type="text" name="firstname" class="input" id="firstname"> 
                        </div>
                        <div class="form-input">
                            <label for="lastname">
                                last name
                            </label>
                            <input type="text" name="lastname" class="input" id="lastname">
                        </div>
                    </div>
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
                    <div class="form-input image">
                        <label for="image">
                           select image
                        </label>
                        <input type="file" name="image" class="input" id="image"> 
                    </div>
                    <div class="form-submit">
                        <input type="submit" name="submit" class="submit" value="Continue To Chat"> 
                    </div>
                    <div class="form-signed">
                        <p> Already Signed Up?  </p><a href="<?= toBase("login")?>">  Login Now </a>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>
<script src="<?= toChat("js/signup.js") ?>"></script>