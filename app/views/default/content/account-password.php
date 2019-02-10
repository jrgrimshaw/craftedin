<section class="main">
    <div class="main-content bg-fix clearfix">
        <div class="container">
        
            <div class="account">
                <div class="account-left">
                    <?php $pageSelected = 'password'; require_once 'includes/account-sidebar.php'; ?>
                </div>

                <div class="account-right">
                    <div class="account-inner slate">
                        <h1>Change Password</h1>

                        <form action="" method="post">
                            <div class="field">
                                <label for="password_current">Current password:</label>
                                <input type="password" name="password_current" class="input input-text" id="password_current">
                            </div>

                            <div class="field">
                            <label for="password_new">New password:</label>
                                <input type="password" name="password_new" class="input input-text" id="password_new">
                            </div>

                            <div class="field">
                                <label for="password_new_again">New password again:</label>
                                <input type="password" name="password_new_again" class="input input-text" id="password_new_again">
                            </div>

                            <input type="submit" class="button button-success" value="Change Password">
                            <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>