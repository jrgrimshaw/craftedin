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

                        <div class="field">
                        <label for="password_new">New password:</label>
                            <input type="password" name="password_new" class="input input-text" id="password_new">
                        </div>

                        <div class="field">
                            <label for="password_new_again">New password again:</label>
                            <input type="password" name="password_new_again" class="input input-text" id="password_new_again">
                        </div>

                        <input type="submit" class="button button-medium button-success wide" value="Change Password">
                        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>