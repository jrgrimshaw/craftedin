<section class="main">
    <div class="main-content bg-fix clearfix">
        <div class="container">
        
            <div class="account">
                <div class="account-left">
                    <?php $pageSelected = 'settings'; require_once 'includes/page-sidebar.php'; ?>
                </div>

                <div class="account-right">
                    <div class="account-inner slate">
                        <h1>Page Settings</h1>

                        <form action="" method="post">
                            <div class="field">
                                <label for="username">Page Handle</label>
                                <input type="text" id="username" maxlength="15" class="input input-text url-input" value="<?php echo escape($data->username); ?>" title="You cannot update your username at this time" disabled>
                                <div class="url-preview">craftedin.co/page/</div>
                            </div>

                            <div class="field">
                                <label for="name">Page Name</label>
                                <input type="text" name="name" class="input input-text" id="name" value="<?php echo escape($data->name); ?>">
                            </div>

                            <div class="field">
                                <label for="location">Location</label>
                                <input type="text" name="location" class="input input-text" id="location" value="<?php echo escape($data->location); ?>">
                            </div>

                            <div class="field">
                                <label for="website">Website</label>
                                <input type="url" name="website" class="input input-text" id="website" value="<?php echo escape($data->website); ?>">
                            </div>

                            <div class="field">
                                <label for="about">About</label>
                                <textarea name="about" class="input input-text input-textarea" id="about"><?php echo escape($data->about); ?></textarea>
                            </div>

                            <input type="submit" class="button button-success" value="Update">
                            <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>