<div class="changelang">
<a href="/chat/changelang" style="color: #ccc ; text-decoration: none"><i class="fas fa-globe lang"></i><?= " ".$lang?></a>
</div>
<div class="login-page">
    <div class="box">
        <div class="left">
        <h2>
            Create Acoount
        </h2>
        <button class="btn-register register-swap">
            Register
        </button>
        </div>
        <div class="right">
        <h2>
            Have An Acount
        </h2>
        <button class="btn-login login-swap active">
            Log IN
        </button>
        </div>
        <div class="form">
                <!-- start login form -->
                <div class="login-form">
                    <h2>
                    Log In
                    </h2>
                    <form>
                        <div class="form-group">
                             <label for="emailLogin"> email </label>
                            <input type="email" name="email" id="emailLoginss="form-control">
                            <div class="invalid-feedback results email " role="alert" style="margin-top: 4px; padding: 4px;display:none"></div>
                        </div>
                        <div class="form-group">
                            <label for="passwordlogin"> password</label>
                            <input type="password" name="password" id="passwordlogin" class="form-control">
                            <div class="invalid-feedback results password " role="alert" style="margin-top: 4px; padding: 4px;display:none"></div>
                        </div>
                        <div class="check-group">
                            <label>
                            <input type="checkbox" name="rememberMe">
                            Remember Me
                            </label>
                        </div>
                        <button class="save btn-login login" data-target="/chat/login/authenticate">Save 
                                Login
                        </button>
                    </form>
                </div>
                <!-- end login form -->
                <!-- start register form -->
                <div class="register-form hidden-form">
                    <h2>
                    REGISTER
                    </h2>
                     <form>
                        <div class="form-group">
                            <label for="userNameRegister">user name</label>
                            <input type="userName" name="userName" id="userNameRegister" class="form-control">
                            <div class="invalid-feedback results userName " role="alert" style="margin-top: 4px; padding: 4px;display:none"></div>
                        </div>
                        <div class="form-group">
                            <label for="email">email </label>
                            <input type="email" name="email" id="emailregister" class="form-control">
                            <div class="invalid-feedback results email " role="alert" style="margin-top: 4px; padding: 4px;display:none"></div>
                        </div>
                        <div class="form-group">
                           <label for="password">password</label>
                            <input type="password" name="password" id="password" class="form-control">
                            <div class="invalid-feedback results password " role="alert" style="margin-top: 4px; padding: 4px;display:none"></div>
                        </div>
                        <div class="form-group">
                            <label for="cPasswordregister">confirm password</label>
                            <input type="password" name="cPassword" id="cPassword" class="form-control">
                            <div class="invalid-feedback results cPassword " role="alert" style="margin-top: 4px; padding: 4px;display:none"></div>
                        </div>

                            <button class="save btn-register register" data-target="/chat/login/register"> 
                            REGISTER
                            </button>
                    </form>
                     <!-- end register form -->
                </div>
        </div>
    </div>
</div>
