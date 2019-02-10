<section class="main">
    <div class="main-content bg-fix clearfix">
        <div class="container">
        
            <div class="account">
                <div class="account-left">
                    <?php $pageSelected = 'settings'; require_once 'includes/account-sidebar.php'; ?>
                </div>

                <div class="account-right">
                    <div class="account-inner slate">
                        <h1>Settings</h1>

                        <form action="" method="post">

                            <div class="field">
                                <label for="username">Username</label>
                                <input type="text" id="username" maxlength="15" class="input input-text url-input" value="<?php echo escape($user->data()->username); ?>" title="You cannot update your username at this time" disabled>
                                <div class="url-preview">craftedin.co/user/</div>
                            </div>

                            <div class="field">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="input input-text" id="email" value="<?php echo escape($user->data()->email); ?>">
                            </div>

                            <div class="field">
                                <label for="name">Full name</label>
                                <input type="text" name="name" class="input input-text" id="name" maxlength="28" value="<?php echo escape($user->data()->name); ?>">
                            </div>

                            <div class="field">
                                <label for="job">Job title</label>
                                <input type="text" name="job" class="input input-text" id="job" maxlength="30" value="<?php echo escape($user->data()->job); ?>">
                            </div>

                            <div class="field">
                                <label for="location">Location</label>
                                <input type="text" name="location" class="input input-text" id="location" maxlength="30" value="<?php echo escape($user->data()->location); ?>">
                            </div>

                            <div class="field">
                                <label for="website">Personal Website</label>
                                <input type="url" name="website" class="input input-text" id="website" value="<?php echo escape($user->data()->website); ?>">
                            </div>

                            <div class="field">
                                <label for="about">About</label>
                                <textarea name="about" class="input input-text input-textarea" maxlength="300" id="about"><?php echo escape($user->data()->about); ?></textarea>
                            </div>

                            <?php if($user->isPremium()): ?>
                            <div class="field">
                                <label>For Hire</label>
                                <input type="radio" name="hire" value="yes" <?php if($user->forHire()): ?>checked<?php endif; ?>> Yes&nbsp;
                                <input type="radio" name="hire" value="no" <?php if(!$user->forHire()): ?>checked<?php endif; ?>> No
                            </div>
                            <?php endif; ?>

                            <input type="submit" class="button button-success" value="Update">
                            <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>