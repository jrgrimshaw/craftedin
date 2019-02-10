<section class="main">
    <div class="main-content bg-fix clearfix">
        <div class="container">
        
            <div class="account">
                <div class="account-left">
                    <?php $pageSelected = 'members'; require_once 'includes/page-sidebar.php'; ?>
                </div>

                <div class="account-right">
                    <div class="account-inner slate">
                        <h1>Editors</h1>
                        <p class="text-grey">Editors are additional users you can add to your page <a href="" class="inline-help show-modal" name="modal-permhelp">[?]</a>.</p>
                        <hr>
                        <br>

                        <h2>Add User</h2>
                        <form action="" method="post">
                            <div class="field">
                                <label for="username">Username</label>
                                <input type="text" name="username" class="input input-text" id="username" autofocus>
                            </div>

                            <div class="field">
                                <input type="submit" class="button button-small button-success" value="Add User">
                                <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                            </div>
                        </form>
                        <br><br>

                        <h2>Editors</h2>

                        <div>
                            <?php if($page->getPageMembers($data->id)->count()): ?>
                                <?php foreach($page->getPageMembers($data->id)->results() as $r): ?>
                                <div class="user clearfix">
                                    <div class="user-left float-left">
                                        <img src="<?php echo USER_AVATAR_DIR . $user->get($r->user_id)->avatar; ?>" alt="<?php escape($user->get($r->user_id)->name); ?>">
                                    </div>
                                    <div class="user-right">
                                        <h3>
                                            <a href="<?php echo '/user/' . escape($user->get($r->user_id)->username); ?>"><?php echo escape($user->get($r->user_id)->name); ?> <?php if($user->get($r->user_id)->verified): ?><span class="user-verified"><span class="ion-checkmark-circled"></span></span><?php endif; ?></a>
                                            <div class="float-right">
                                                <?php if(!$page->isPageOwner($data->id, $r->user_id)): ?><a href="?manage=members&remove=<?php echo $r->user_id; ?>" class="button button-warning button-tiny"><span class="ion-close-circled"></span> Remove</a><?php endif; ?>
                                            </div>
                                        </h3>

                                        <div class="user-info">
                                            <p><?php if($page->isPageOwner($data->id, $r->user_id)): ?><strong class="text-gold">Owner</strong><?php else: echo 'Editor'; endif; ?> <a class="inline-help show-modal" name="modal-permhelp" href="">[?]</a></p>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                            <div class="no-posts">
                                <div class="icon ion-sad-outline"></div>
                                <div class="message"><strong>There are currently no members added to this team.</strong><br>Use the field above to add some members.</div>
                            </div>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<div class="modal" id="modal-permhelp">
    <div class="modal-shade"></div>
    <div class="modal-container">
        <div class="modal-container-inner">
            <div class="modal-header clearfix">
                <div class="float-left">Page Permissions Help</div>
                <div class="float-right"><a href="" class="close-modal"><span class="ion-close"></span></a></div>
            </div>
            <div class="modal-body">
                <div class="modal-body-fields">
                    <p><strong>Owners</strong> (the page creator):</p>
                    <p class="text-grey">Owners have full control over a page. They can modify the page and post - as well as add and remove <em>editors</em> and delete the page. Owners are non-transferrable or addable, and are the only members to receive notifications for the page.</p>
                    <br>
                    <p><strong>Editors</strong> (additional page members):</p>
                    <p class="text-grey">Editors are additional users addable to a page, who are able to modify the page and post - <em>but not modify members</em>. Editors are freely addable to a page by the <em>owner</em>, and they can add as many as they like. Editors can leave the page any time they like.</p>
                </div>
            </div>
        </div>
    </div>
</div>