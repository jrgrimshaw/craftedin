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
    <div class="main-content-bg auth-main bg-fix clearfix" style="background-image: url(/static/images/backgrounds/index3.jpg);">
        <div class="container">

            <div class="auth auth-login animated fadeIn">
                <div class="auth-header"><a href="/"><div class="header-logo"></div></a></div>

                <div class="auth-body">
                    <form action="" method="post">
                        <div class="field">
                            <label for="username">Username or email</label>
                            <input type="text" name="username" id="username" class="input input-text" value="<?php echo escape(Input::get('username')); ?>" tabindex="1" autofocus>
                        </div>

                        <div class="field">
                            <label for="password">Password<span class="float-right"><a href="/forgot">Forgotten?</a></span></label>
                            <input type="password" name="password" id="password" class="input input-text" tabindex="2">
                        </div>

                        <div class="field clearfix">
                            <div class="float-left">
                                <label for="remember">
                                    <input type="checkbox" name="remember" id="remember" class="input-check" checked> Keep me signed in
                                </label>
                            </div>
                            <div class="float-right">
                                <label style="cursor:default"><span class="ion-locked"></span> Secure</label>
                            </div>
                        </div>

                        <input type="submit" class="button button-medium button-primary wide" value="Log in">
                        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                    </form>
                </div>

                <div class="auth-footer">
                    Need an account? <a href="/signup">Sign up here</a>.
                </div>
            </div>
        </div>
    </div>
</section>