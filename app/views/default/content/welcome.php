<section class="main">
    <div class="main-content bg-fix clearfix">
        <div class="container">
            <div class="welcome">
                <h1>Get Started</h1>

                <?php if(!$page): ?>
                    <p class="subtitle">Welcome to CraftedIn</p>

                    <div class="welcome-inner slate">
                        <div class="welcome-body bg">
                            <div class="w-ml">
                                <p id="w-ml-1">Welcome</p>
                                <p id="w-ml-2" class="hidden">Bienvenue</p>
                                <p id="w-ml-3" class="hidden">Bienvenido</p>
                                <p id="w-ml-4" class="hidden">Velkommen</p>
                                <p id="w-ml-5" class="hidden">Welkom</p>
                                <p id="w-ml-6" class="hidden">Willkommen</p>
                                <p id="w-ml-7" class="hidden">Välkommen</p>
                                <p id="w-ml-8" class="hidden">欢迎</p>
                                <p id="w-ml-9" class="hidden">ようこそ</p>
                                <p id="w-ml-10" class="hidden">Welcome</p>
                            </div>
                        </div>

                        <div class="welcome-footer clearfix">
                            <div class="float-right">
                                <a href="/welcome/2" class="button button-success">Next</a>
                            </div>
                        </div>
                    </div>
                <?php elseif($page === 2): ?>
                    <p class="subtitle">Complete your profile</p>

                    <div class="welcome-inner slate">
                        <form action="" method="post">
                            <div class="welcome-body">
                                <div class="field">
                                    <label for="name">Full name</label>
                                    <input type="text" name="name" class="input input-text" id="name" value="<?php echo escape($user->data()->name); ?>">
                                </div>

                                <div class="field">
                                    <label for="job">Job title</label>
                                    <input type="text" name="job" class="input input-text" id="job" value="<?php echo escape($user->data()->job); ?>">
                                </div>

                                <div class="field">
                                    <label for="location">Location</label>
                                    <input type="text" name="location" class="input input-text" id="location" value="<?php echo escape($user->data()->location); ?>">
                                </div>

                                <div class="field">
                                    <label for="website">Personal Website</label>
                                    <input type="url" name="website" class="input input-text" id="website" value="<?php echo escape($user->data()->website); ?>">
                                </div>

                                <div class="field">
                                    <label for="about">About</label>
                                    <textarea name="about" class="input input-text input-textarea" id="about"><?php echo escape($user->data()->about); ?></textarea>
                                </div>
                            </div>

                            <div class="welcome-footer clearfix">
                                <div class="float-right">
                                    <a href="/welcome/3" class="button button-boring">Skip</a>&nbsp;&nbsp;
                                    <input type="submit" value="Next" class="button button-success">
                                    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                                </div>
                            </div>
                        </form>
                    </div>
                <?php elseif($page === 3): ?>
                    <p class="subtitle">Add some pictures to your profile</p>

                    <div class="welcome-inner slate">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="welcome-body">
                                <div class="account-avatar">
                                    <img src="<?php echo USER_AVATAR_DIR . $user->data()->avatar; ?>" alt="<?php echo escape($user->data()->name); ?>">
                                    <div class="field field-border">
                                        <input type="file" name="avatar">
                                    </div>
                                </div>
                            </div>

                            <div class="welcome-footer clearfix">
                                <div class="float-right">
                                    <a href="/welcome/4" class="button button-boring">Skip</a>&nbsp;&nbsp;
                                    <input type="submit" value="Next" class="button button-success">
                                </div>
                            </div>
                        </form>
                    </div>
                <?php elseif($page === 4): ?>
                    <p class="subtitle">Why not follow these people?</p>

                    <div class="welcome-inner slate">
                        <form action="" method="post">
                            <div class="welcome-body">
                                <?php $r = $user->get(3); ?>
                                <div class="user clearfix">
                                    <div class="user-left float-left">
                                        <img src="<?php echo USER_AVATAR_DIR . $r->avatar; ?>" alt="<?php escape($r->name); ?>">
                                    </div>
                                    <div class="user-right">
                                        <h3>
                                            <a href="<?php echo '/user/' . escape($r->username); ?>"><?php echo escape($r->name); ?> <?php if($r->verified): ?><span class="user-verified"><span class="ion-checkmark-circled"></span></span><?php endif; ?></a>
                                            <div class="float-right">
                                                <?php if($user->isLoggedIn()) {
                                                    if($user->data()->id === $r->id) { ?>
                                                        <a href="/account/settings" class="button button-primary button-tiny">Edit Profile</a>
                                                    <?php } else {
                                                        if($user->isFollowing($r->id)) { ?>
                                                            <a href="/ajax/unfollow?user_id=<?php echo $r->id; ?>" class="button button-warning button-tiny follow-button"><span class="ion-person-add">&nbsp;</span> <span class="follow-button-text">Unfollow</span></a>
                                                        <?php } else { ?>
                                                            <a href="/ajax/follow?user_id=<?php echo $r->id; ?>" class="button button-success button-tiny follow-button"><span class="ion-person-add">&nbsp;</span> <span class="follow-button-text">Follow</span></a>
                                                        <?php } ?>
                                                    <?php }
                                                } else { ?>
                                                    &nbsp; <!-- DO NOT DELETE THIS -->
                                                <?php } ?>
                                            </div>
                                        </h3>

                                        <div class="user-info">
                                            <?php if($r->job != null) { ?><p class="job"><span class="ion-briefcase"></span> <?php echo escape($r->job); ?></p>
                                            <?php } elseif($r->location != null) { ?><p><span class="ion-location"></span> <?php echo escape($r->location); ?></p>
                                            <?php } else { ?><p><span class="ion-clock"></span> Joined <?php echo date("F Y", strtotime($r->joined)); ?></p><?php } ?>
                                        </div>
                                    </div>
                                </div>

                                <?php $r = $user->get(5); ?>
                                <div class="user clearfix">
                                    <div class="user-left float-left">
                                        <img src="<?php echo USER_AVATAR_DIR . $r->avatar; ?>" alt="<?php escape($r->name); ?>">
                                    </div>
                                    <div class="user-right">
                                        <h3>
                                            <a href="<?php echo '/user/' . escape($r->username); ?>"><?php echo escape($r->name); ?> <?php if($r->verified): ?><span class="user-verified"><span class="ion-checkmark-circled"></span></span><?php endif; ?></a>
                                            <div class="float-right">
                                                <?php if($user->isLoggedIn()) {
                                                    if($user->data()->id === $r->id) { ?>
                                                        <a href="/account/settings" class="button button-primary button-tiny">Edit Profile</a>
                                                    <?php } else {
                                                        if($user->isFollowing($r->id)) { ?>
                                                            <a href="/ajax/unfollow?user_id=<?php echo $r->id; ?>" class="button button-warning button-tiny follow-button"><span class="ion-person-add">&nbsp;</span> <span class="follow-button-text">Unfollow</span></a>
                                                        <?php } else { ?>
                                                            <a href="/ajax/follow?user_id=<?php echo $r->id; ?>" class="button button-success button-tiny follow-button"><span class="ion-person-add">&nbsp;</span> <span class="follow-button-text">Follow</span></a>
                                                        <?php } ?>
                                                    <?php }
                                                } else { ?>
                                                    &nbsp; <!-- DO NOT DELETE THIS -->
                                                <?php } ?>
                                            </div>
                                        </h3>

                                        <div class="user-info">
                                            <?php if($r->job != null) { ?><p class="job"><span class="ion-briefcase"></span> <?php echo escape($r->job); ?></p>
                                            <?php } elseif($r->location != null) { ?><p><span class="ion-location"></span> <?php echo escape($r->location); ?></p>
                                            <?php } else { ?><p><span class="ion-clock"></span> Joined <?php echo date("F Y", strtotime($r->joined)); ?></p><?php } ?>
                                        </div>
                                    </div>
                                </div>

                                <?php $r = $user->get(1); ?>
                                <div class="user clearfix">
                                    <div class="user-left float-left">
                                        <img src="<?php echo USER_AVATAR_DIR . $r->avatar; ?>" alt="<?php escape($r->name); ?>">
                                    </div>
                                    <div class="user-right">
                                        <h3>
                                            <a href="<?php echo '/user/' . escape($r->username); ?>"><?php echo escape($r->name); ?> <?php if($r->verified): ?><span class="user-verified"><span class="ion-checkmark-circled"></span></span><?php endif; ?></a>
                                            <div class="float-right">
                                                <?php if($user->isLoggedIn()) {
                                                    if($user->data()->id === $r->id) { ?>
                                                        <a href="/account/settings" class="button button-primary button-tiny">Edit Profile</a>
                                                    <?php } else {
                                                        if($user->isFollowing($r->id)) { ?>
                                                            <a href="/ajax/unfollow?user_id=<?php echo $r->id; ?>" class="button button-warning button-tiny follow-button"><span class="ion-person-add">&nbsp;</span> <span class="follow-button-text">Unfollow</span></a>
                                                        <?php } else { ?>
                                                            <a href="/ajax/follow?user_id=<?php echo $r->id; ?>" class="button button-success button-tiny follow-button"><span class="ion-person-add">&nbsp;</span> <span class="follow-button-text">Follow</span></a>
                                                        <?php } ?>
                                                    <?php }
                                                } else { ?>
                                                    &nbsp; <!-- DO NOT DELETE THIS -->
                                                <?php } ?>
                                            </div>
                                        </h3>

                                        <div class="user-info">
                                            <?php if($r->job != null) { ?><p class="job"><span class="ion-briefcase"></span> <?php echo escape($r->job); ?></p>
                                            <?php } elseif($r->location != null) { ?><p><span class="ion-location"></span> <?php echo escape($r->location); ?></p>
                                            <?php } else { ?><p><span class="ion-clock"></span> Joined <?php echo date("F Y", strtotime($r->joined)); ?></p><?php } ?>
                                        </div>
                                    </div>
                                </div>

                                <?php $r = $user->get(2); ?>
                                <div class="user clearfix">
                                    <div class="user-left float-left">
                                        <img src="<?php echo USER_AVATAR_DIR . $r->avatar; ?>" alt="<?php escape($r->name); ?>">
                                    </div>
                                    <div class="user-right">
                                        <h3>
                                            <a href="<?php echo '/user/' . escape($r->username); ?>"><?php echo escape($r->name); ?> <?php if($r->verified): ?><span class="user-verified"><span class="ion-checkmark-circled"></span></span><?php endif; ?></a>
                                            <div class="float-right">
                                                <?php if($user->isLoggedIn()) {
                                                    if($user->data()->id === $r->id) { ?>
                                                        <a href="/account/settings" class="button button-primary button-tiny">Edit Profile</a>
                                                    <?php } else {
                                                        if($user->isFollowing($r->id)) { ?>
                                                            <a href="/ajax/unfollow?user_id=<?php echo $r->id; ?>" class="button button-warning button-tiny follow-button"><span class="ion-person-add">&nbsp;</span> <span class="follow-button-text">Unfollow</span></a>
                                                        <?php } else { ?>
                                                            <a href="/ajax/follow?user_id=<?php echo $r->id; ?>" class="button button-success button-tiny follow-button"><span class="ion-person-add">&nbsp;</span> <span class="follow-button-text">Follow</span></a>
                                                        <?php } ?>
                                                    <?php }
                                                } else { ?>
                                                    &nbsp; <!-- DO NOT DELETE THIS -->
                                                <?php } ?>
                                            </div>
                                        </h3>

                                        <div class="user-info">
                                            <?php if($r->job != null) { ?><p class="job"><span class="ion-briefcase"></span> <?php echo escape($r->job); ?></p>
                                            <?php } elseif($r->location != null) { ?><p><span class="ion-location"></span> <?php echo escape($r->location); ?></p>
                                            <?php } else { ?><p><span class="ion-clock"></span> Joined <?php echo date("F Y", strtotime($r->joined)); ?></p><?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="welcome-footer clearfix">
                                <div class="float-right">
                                    <a href="/welcome/5" class="button button-boring">Skip</a>&nbsp;&nbsp;
                                    <a href="/welcome/5" class="button button-success">Next</a>
                                </div>
                            </div>
                        </form>
                    </div>
                <?php elseif($page === 5): ?>
                    <p class="subtitle">Awesome! All done!</p>

                    <div class="welcome-inner slate">
                        <form action="" method="post">
                            <div class="welcome-footer clearfix">
                                <div class="float-right">
                                    <input type="submit" value="Finish" class="button button-success">
                                    <input type="hidden" name="sc" value="y">
                                </div>
                            </div>
                        </form>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>