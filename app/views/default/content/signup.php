<?php if(Session::exists('success')) { ?>
<div class="messages bg-fix">
    <div class="message message-success">
        <span class="ion-checkmark-circled"></span> <?php echo randomSuccessMessage(); ?> <?php echo Session::flash('success'); ?>
        <div class="message-close float-right"><a href=""><span class="ion-close"></span></a></div>
    </div>
</div>
<?php } else if(Session::exists('error')) { ?>
<div class="messages bg-fix">
    <div class="message message-error">
        <span class="ion-alert-circled"></span> <?php echo randomErrorMessage(); ?> <?php echo Session::flash('error'); ?>
        <div class="message-close float-right"><a href=""><span class="ion-close"></span></a></div>
    </div>
</div>
<?php } else if(Session::exists('info')) { ?>
<div class="messages bg-fix">
    <div class="message message-info">
        <span class="ion-information-circled"></span> <?php echo Session::flash('info'); ?>
        <div class="message-close float-right"><a href=""><span class="ion-close"></span></a></div>
    </div>
</div>
<?php
}
?>

<section class="main">
    <div class="main-content-bg auth-main bg-fix clearfix" style="background-image: url(/static/images/backgrounds/index2.jpg);">
        <div class="container">
            <div class="auth auth-signup animated fadeIn">
                <div class="auth-header"><a href="/"><div class="header-logo"></div></a></div>

                <div class="auth-body">
                    <form action="" method="post">
                        <div class="field">
                            <label for="username">Choose a username</label>
                            <input type="text" name="username" id="username" maxlength="15" class="input input-text url-input" value="<?php echo escape(Input::get('username')); ?>" autofocus>
                            <div class="url-preview">craftedin.co/user/</div>
                        </div>

                        <div class="field">
                            <label for="email">Your email</label>
                            <input type="email" name="email" class="input input-text" id="email" value="<?php echo escape(Input::get('email')); ?>">
                        </div>

                        <div class="field">
                            <label for="password">Choose a password</label>
                            <input type="password" name="password" id="password" class="input input-text" value="<?php echo escape(Input::get('password')); ?>">
                        </div>

                        <div class="field">
                            <label for="name">Your full name</label>
                            <input type="text" name="name" id="name" class="input input-text" value="<?php echo escape(Input::get('name')); ?>">
                        </div>

                        <div class="field">
                            <label>Are you <a href="/static/images/external/1d8ot6.jpg" class="text-grey" target="_blank">human</a>?</label>
                            <div class="g-recaptcha" data-sitekey="6Lfp9gITAAAAAKrlUR-Mal6EHlzaZ6Q038C0oPDF"></div>
                        </div>
                        <script src="//www.google.com/recaptcha/api.js"></script>
                        
                        <div class="field clearfix">
                            <div class="float-left">
                                <label for="remember">
                                    <input type="radio" name="remember" id="remember" class="input-check" checked> By signing up, you agree to the <a href="/legal/privacy">privacy policy</a>.
                                </label>
                            </div>
                            <div class="float-right">
                                <label style="cursor:default"><span class="ion-locked"></span> Secure</label>
                            </div>
                        </div>

                        <input type="submit" class="button button-medium button-success wide" value="Create a Free Account">
                        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                    </form>
                </div>

                <div class="auth-footer">
                    Already have an account? <a href="/login">Log in here</a>.
                </div>
            </div>
        </div>
    </div>
</section>