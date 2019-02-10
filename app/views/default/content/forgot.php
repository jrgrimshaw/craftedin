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
    <div class="main-content-bg auth-main bg-fix clearfix" style="background-image: url(https://images.unsplash.com/photo-1478515463067-d20f52aace26?ixlib=rb-0.3.5&q=80&fm=jpg&crop=entropy&cs=tinysrgb&s=f400d8c9bdb047f75c4fcd2a8f81a0e9);">
        <div class="container">

            <div class="auth auth-login animated fadeIn">
                <div class="auth-header"><a href="/"><div class="header-logo"></div></a></div>

                <div class="auth-body">
                    <form action="" method="post">
                        <div class="field clearfix">
                            <p class="text-grey">If we can find your account, we'll send instructions for resetting your password to your email.</p>
                        </div>
                        <hr>

                        <div class="field">
                            <label for="username">Username or email <span class="float-right"><a href="/support">Forgotten?</a></span></label>
                            <input type="text" name="username" id="username" class="input input-text" value="<?php echo escape(Input::get('username')); ?>" autofocus>
                        </div>

                        <input type="submit" class="button button-medium button-success wide" value="Reset Password">
                        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                    </form>
                </div>

                <div class="auth-footer">
                    Remembered? <a href="/login">Log in here</a>.
                </div>
            </div>
        </div>
    </div>
</section>