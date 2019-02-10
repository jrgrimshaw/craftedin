<section class="main">
    <div class="main-content bg-fix clearfix">
        <div class="container">
        
            <div class="account">
                <div class="account-left">
                    <?php $pageSelected = 'compose'; require_once 'includes/account-sidebar.php'; ?>
                </div>

                <div class="account-right">
                    <div class="messages-inner slate">
                        <h1>Compose</h1>

                        <form action="" method="post">
                            <div class="field">
                                <label for="to">To</label>
                                <input type="text" name="to" class="input input-text" id="to" placeholder="Type a username, for example: craftedin" value="<?php echo escape(Input::get('t')); ?>" autofocus>
                            </div>

                            <div class="field">
                                <label for="subject">Subject</label>
                                <input type="text" name="subject" class="input input-text" id="subject" value="<?php echo escape(Input::get('s')); ?>">
                            </div>

                            <div class="field">
                                <label for="message">Message</label>
                                <textarea name="message" class="input input-text input-textarea" id="message"></textarea>
                            </div>

                            <input type="submit" class="button button-success" value="Send Message">
                            <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>