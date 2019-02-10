<header class="user-subheader">
    <div class="user-subheader-inner bg-fix clearfix">
        <div class="container">
            <div class="float-left">
                <?php if($user->isPremium($data->id)): ?>
                <div class="user-subheader-tags">
                    <?php if($user->isPremium($data->id)): ?>
                    <a href="/plus"><div class="tag tag-green <?php if($user->forHire($data->id)): ?>sectioned<?php endif; ?>">Plus</div></a>
                    <?php if($user->forHire($data->id)): ?><a href="" class="show-modal" name="modal-hire"><div class="tag tag-blue subsection">For Hire</div></a><?php endif; ?>    <!--  need to do modal!!!!! -->
                    <?php endif; ?>
                </div>
                <?php endif; ?>
                <div class="profile-stats">
                    <ul>
                        <li><strong><?php echo number_format($postsCount); ?></strong> <span>Post<?php if($postsCount === 1) { echo ''; } else { echo 's'; } ?></span></li>
                        <li><a href="" class="show-modal" name="modal-following"><strong><?php echo number_format($followingCount); ?></strong> <span>Following</span></a></li>
                        <li><a href="" class="show-modal" name="modal-followers"><strong><?php echo number_format($followersCount); ?></strong> <span>Follower<?php if($followersCount === 1) { echo ''; } else { echo 's'; } ?></span></a></li>
                        <li><strong><?php echo number_format($viewCount); ?></strong> <span>View<?php if($viewCount == 1) { echo ''; } else { echo 's'; } ?></span></li>
                    </ul>
                </div>
            </div>
            <div class="float-right">
                <?php if($user->isLoggedIn()): ?>
                    <?php if($user->data()->id === $data->id) { ?>
                        <a href="/account/settings" class="button button-primary button-small"><span class="ion-edit">&nbsp;</span> Edit Profile</a>
                    <?php } else { ?>
                        <a href="/messages/compose?t=<?php echo $data->username; ?>" class="button button-boring button-small tooltip" title="Message"><span class="ion-android-mail"></span></a>
                        <a href="/ajax/report-user?user_id=<?php echo $data->id; ?>" class="button button-boring button-small tooltip report-user" title="Report"><span class="ion-flag"></span></a>
                        <?php if($user->isFollowing($data->id)) { ?>
                            <a href="/ajax/unfollow?user_id=<?php echo $data->id; ?>" class="button button-warning button-small follow-button"><span class="ion-person-add">&nbsp;</span> <span class="follow-button-text">Unfollow</span></a>
                        <?php } else { ?>
                            <a href="/ajax/follow?user_id=<?php echo $data->id; ?>" class="button button-success button-small follow-button"><span class="ion-person-add">&nbsp;</span> <span class="follow-button-text">Follow</span></a>
                        <?php } ?>
                    <?php } ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>

<section class="main">
    <div class="profile">
        <div class="profile-background" <?php if($data->header != null) { ?>style="background-image: url(<?php echo USER_HEADER_DIR . $data->header; ?>);"<?php } ?>></div>

        <div class="profile-header">
            <div class="profile-header-inner">
                <div class="profile-header-avatar">
                    <a href="" class="show-modal" name="modal-avatar"><img src="<?php echo USER_AVATAR_DIR . $data->avatar; ?>" alt="<?php echo escape($data->name); ?>"></a>
                </div>
                <h1>
                    <span class="name"><?php echo escape($data->name); ?></span>
                    <?php if($data->verified): ?><span class="medal"><span class="user-verified ion-checkmark-circled tooltip" title="Verified User"></span></span><?php endif; ?>
                </h1>
                <h2 class="username">@<?php echo escape($data->username); ?></h2>
                <?php if($data->about != null): ?><p class="about"><?php echo Hashmention::parse(linkify(escape($data->about))); ?></p><?php endif; ?>
            </div>
        </div>

        <?php if(DB::getInstance()->get('following', ['user_id', '=', $data->id])->count()): ?>
        <div class="modal" id="modal-following">
            <div class="modal-shade"></div>
            <div class="modal-container">
                <div class="modal-container-inner">
                    <div class="modal-header clearfix">
                        <div class="float-left">Following</div>
                        <div class="float-right"><a href="" class="close-modal"><span class="ion-close"></span></a></div>
                    </div>
                    <div class="modal-body">
                        <div class="modal-body-users">
                            <ul>
                                <?php
                                foreach(DB::getInstance()->get('following', ['user_id', '=', $data->id])->results() as $l):
                                ?>
                                <li>
                                    <div class="user-left float-left">
                                        <img src="<?php echo USER_AVATAR_DIR . $user->get($l->user_following_id)->avatar; ?>" alt="<?php escape($user->get($l->user_following_id)->name); ?>">
                                    </div>
                                    <div class="user-right">
                                        <h3>
                                            <a href="<?php echo '/user/' . escape($user->get($l->user_following_id)->username); ?>"><?php echo escape($user->get($l->user_following_id)->name); ?> <?php if($user->get($l->user_following_id)->verified): ?><span class="user-verified"><span class="ion-checkmark-circled"></span></span><?php endif; ?></a>
                                            <div class="float-right">
                                                <?php if($user->isLoggedIn()) {
                                                    if($user->data()->id === $user->get($l->user_following_id)->id) { ?>
                                                        <a href="/account/settings" class="button button-primary button-tiny">Edit Profile</a>
                                                    <?php } else {
                                                        if($user->isFollowing($user->get($l->user_following_id)->id)) { ?>
                                                            <a href="/ajax/unfollow?user_id=<?php echo $l->user_following_id; ?>" class="button button-warning button-tiny follow-button"><span class="ion-person-add">&nbsp;</span> <span class="follow-button-text">Unfollow</span></a>
                                                        <?php } else { ?>
                                                            <a href="/ajax/follow?user_id=<?php echo $l->user_following_id; ?>" class="button button-success button-tiny follow-button"><span class="ion-person-add">&nbsp;</span> <span class="follow-button-text">Follow</span></a>
                                                        <?php } ?>
                                                    <?php }
                                                } else { ?>
                                                    &nbsp; <!-- DO NOT DELETE THIS -->
                                                <?php } ?>
                                            </div>
                                        </h3>

                                        <div class="user-info">
                                            <?php if($user->get($l->user_following_id)->job != null) { ?><p class="job"><span class="ion-briefcase"></span> <?php echo escape($user->get($l->user_following_id)->job); ?></p>
                                            <?php } elseif($user->get($l->user_following_id)->location != null) { ?><p><span class="ion-location"></span> <?php echo escape($user->get($l->user_following_id)->location); ?></p>
                                            <?php } else { ?><p><span class="ion-android-time"></span> Joined <?php echo date("F Y", strtotime($user->get($l->user_following_id)->joined)); ?></p><?php } ?>
                                        </div>
                                    </div>
                                </li>
                                <?php
                                endforeach;
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if(DB::getInstance()->get('following', ['user_following_id', '=', $data->id])->count()): ?>
        <div class="modal" id="modal-followers">
            <div class="modal-shade"></div>
            <div class="modal-container">
                <div class="modal-container-inner">
                    <div class="modal-header clearfix">
                        <div class="float-left">Followers</div>
                        <div class="float-right"><a href="" class="close-modal"><span class="ion-close"></span></a></div>
                    </div>
                    <div class="modal-body">
                        <div class="modal-body-users">
                            <ul>
                                <?php
                                foreach(DB::getInstance()->get('following', ['user_following_id', '=', $data->id])->results() as $l):
                                ?>
                                <li>
                                    <div class="user-left float-left">
                                        <img src="<?php echo USER_AVATAR_DIR . $user->get($l->user_id)->avatar; ?>" alt="<?php escape($user->get($l->user_id)->name); ?>">
                                    </div>
                                    <div class="user-right">
                                        <h3>
                                            <a href="<?php echo '/user/' . escape($user->get($l->user_id)->username); ?>"><?php echo escape($user->get($l->user_id)->name); ?> <?php if($user->get($l->user_id)->verified): ?><span class="user-verified"><span class="ion-checkmark-circled"></span></span><?php endif; ?></a>
                                            <div class="float-right">
                                                <?php if($user->isLoggedIn()) {
                                                    if($user->data()->id === $user->get($l->user_id)->id) { ?>
                                                        <a href="/account/settings" class="button button-primary button-tiny">Edit Profile</a>
                                                    <?php } else {
                                                        if($user->isFollowing($user->get($l->user_id)->id)) { ?>
                                                            <a href="/ajax/unfollow?user_id=<?php echo $l->user_id; ?>" class="button button-warning button-tiny follow-button"><span class="ion-person-add">&nbsp;</span> <span class="follow-button-text">Unfollow</span></a>
                                                        <?php } else { ?>
                                                            <a href="/ajax/follow?user_id=<?php echo $l->user_id; ?>" class="button button-success button-tiny follow-button"><span class="ion-person-add">&nbsp;</span> <span class="follow-button-text">Follow</span></a>
                                                        <?php } ?>
                                                    <?php }
                                                } else { ?>
                                                    &nbsp; <!-- DO NOT DELETE THIS -->
                                                <?php } ?>
                                            </div>
                                        </h3>

                                        <div class="user-info">
                                            <?php if($user->get($l->user_id)->job != null) { ?><p class="job"><span class="ion-briefcase"></span> <?php echo escape($user->get($l->user_id)->job); ?></p>
                                            <?php } elseif($user->get($l->user_id)->location != null) { ?><p><span class="ion-location"></span> <?php echo escape($user->get($l->user_id)->location); ?></p>
                                            <?php } else { ?><p><span class="ion-android-time"></span> Joined <?php echo date("F Y", strtotime($user->get($l->user_id)->joined)); ?></p><?php } ?>
                                        </div>
                                    </div>
                                </li>
                                <?php
                                endforeach;
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div class="main-content bg-fix clearfix">
            <div class="container">
                <div class="profile-body">
                    <div class="profile-sidebar">
                        <div class="sidebar-widget">
                            <div class="widget-header">
                                <h3>
                                    <span class="icon ion-android-happy"></span> About
                                </h3>
                            </div>

                            <div class="widget-body clearfix">
                                <div class="widget-list">
                                    <?php if(strtotime(date('Y-m-d H:i:s')) < strtotime($data->last_online) + 600): ?>
                                    <p class="text-green"><span class="text-green">&#x25cf;</span> Online</p>
                                    <?php elseif(strtotime(date('Y-m-d H:i:s')) < strtotime($data->last_online) + 1800): ?>
                                    <p class="text-orange"><span class="text-orange">&#x25cf;</span> Idle</p>
                                    <?php elseif(strtotime(date('Y-m-d H:i:s')) > strtotime($data->last_online) + 1800): ?>
                                    <p class="text-red"><span class="text-red">&#x25cf;</span> Offline</p>
                                    <?php endif; ?>
                                    <p><span class="ion-eye"></span> Last seen <abbr class="timeago" title="<?php echo date(DATE_ISO8601, strtotime($data->last_online)); ?>"></abbr></p>
                                    <?php if($data->job != null) { ?><p class="job"><span class="ion-briefcase"></span> <?php echo escape($data->job); ?></p><?php } ?>
                                    <?php if($data->location != null) { ?><p><span class="ion-location"></span> <?php echo escape($data->location); ?></p><?php } ?>
                                    <?php if($data->website != null) { ?><p><span class="ion-link"></span> <?php echo linkify(escape($data->website)); ?></p><?php } ?>
                                    <p><span class="ion-android-time"></span> Joined <?php echo date("F Y", strtotime($data->joined)); ?></p>
                                </div>
                            </div>
                        </div>

                        <div class="sidebar-widget">
                            <div class="widget-header">
                                <h3>
                                    <span class="icon ion-ribbon-b"></span> Reputation
                                </h3>
                            </div>
                            
                            <div class="widget-body clearfix">
                                <div class="widget-reputation">
                                    <?php if($reputation >= 0 && $reputation < 500) { ?>
                                    <div class="points-circle circle-beginner">
                                        <h2 class="rep-count"><?php echo number_format($reputation); ?></h2>
                                        <span class="tag"><span class="ion-university"></span> Beginner</span>
                                    </div>
                                    <?php } else if($reputation >= 500 && $reputation < 1000) { ?>
                                    <div class="points-circle circle-bronze">
                                        <h2 class="rep-count"><?php echo number_format($reputation); ?></h2>
                                        <span class="tag"><span class="ion-ribbon-b"></span> Bronze</span>
                                    </div>
                                    <?php } else if($reputation >= 1000 && $reputation < 2500) { ?>
                                    <div class="points-circle circle-silver">
                                        <h2 class="rep-count"><?php echo number_format($reputation); ?></h2>
                                        <span class="tag"><span class="ion-ribbon-b"></span> Silver</span>
                                    </div>
                                    <?php } else if($reputation >= 2500 && $reputation < 5000) { ?>
                                    <div class="points-circle circle-gold">
                                        <h2 class="rep-count"><?php echo number_format($reputation); ?></h2>
                                        <span class="tag"><span class="ion-ribbon-b"></span> Gold</span>
                                    </div>
                                    <?php } else if($reputation >= 5000 && $reputation < 10000) { ?>
                                    <div class="points-circle circle-platinum">
                                        <h2 class="rep-count"><?php echo number_format($reputation); ?></h2>
                                        <span class="tag"><span class="ion-ribbon-b"></span> Platinum</span>
                                    </div>
                                    <?php } else if($reputation >= 10000 && $reputation < 20000) { ?>
                                    <div class="points-circle circle-diamond">
                                        <h2 class="rep-count"><?php echo number_format($reputation); ?></h2>
                                        <span class="tag"><span class="ion-ribbon-b"></span> Diamond</span>
                                    </div>
                                    <?php } else if($reputation >= 20000) { ?>
                                    <div class="points-circle circle-craftedinium">
                                        <h2 class="rep-count"><?php echo number_format($reputation); ?></h2>
                                        <span class="tag"><span class="ion-ribbon-b"></span> Craftedinium</span>
                                    </div>
                                    <?php } ?>

                                    <div class="progress">
                                        <div class="progress-bar"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php echo sidebarAd(); ?>
                    </div>

                    <div class="profile-content">
                        <?php if($user->isLoggedIn() && $data->id === $user->data()->id): ?>
                        <div class="post">
                            <div class="post-main-post slate">
                                <form action="/new/post" method="post" enctype="multipart/form-data">
                                    <textarea name="post" id="post-input" class="input post-input" placeholder="What are you working on?" tabindex="2" maxlength="5000" style="height:55px;overflow:hidden;"></textarea>
                                    <div class="post-main-footer post-main-options clearfix hidden">
                                        <div class="float-left">
                                            <input type="file" name="photo" id="add-photo">
                                            <a href="" id="add-photo-button" class="button button-success"><span class="ion-image">&nbsp;</span> Add photo</a>
                                            <img src="" class="photo-preview"><span class="photo-preview-check"><span class="ion-checkmark-circled"></span></span>
                                        </div>
                                        <div class="float-right">
                                            <select name="as" class="input input-select">
                                                <option value="<?php echo $user->data()->id; ?>" selected>Post for myself</option>
                                            </select>
                                            <span class="post-characters-remaining">5000</span>
                                            <button type="submit" class="button button-primary"><span class="ion-paper-airplane">&nbsp;</span> Post</button>
                                        </div>
                                    </div>
                                    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                                    <input type="hidden" name="profile" value="1">
                                </form>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php
                        if($postsCount) {
                            ?>
                            <div class="posts"></div>

                            <?php if($postsCount >= 15): ?><a href="" class="posts-load button"><span class="ion-loop"></span> Load more</a><?php endif; ?>
                            <?php
                        } else {
                            ?>
                            <div class="no-posts">
                                <div class="icon ion-sad-outline"></div>
                                <div class="message"><strong>This user has not posted anything yet.</strong></div>
                            </div>
                            <?php
                        }
                        ?>

                        <script>
                            loadmore('/ajax/posts?type=profile&user=<?php echo $data->id ?>');
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal modal-full" id="modal-avatar">
    <div class="modal-shade"></div>
    <div class="modal-container">
        <div class="modal-container-inner">
            <div class="modal-header clearfix">
                <div class="float-left"><?php echo $data->name ?>'s Photo</div>
                <div class="float-right"><a href="" class="close-modal"><span class="ion-close"></span></a></div>
            </div>
            <div class="modal-body">
                <img src="<?php echo USER_AVATAR_FS_DIR . $data->avatar; ?>" alt="<?php echo $data->name ?>'s Photo">
            </div>
        </div>
    </div>
</div>

<?php if($user->forHire($data->id)): ?>
<div class="modal" id="modal-hire">
    <div class="modal-shade"></div>
    <div class="modal-container">
        <div class="modal-container-inner">
            <div class="modal-header clearfix">
                <div class="float-left">Work Inquiry</div>
                <div class="float-right"><a href="" class="close-modal"><span class="ion-close"></span></a></div>
            </div>
            <div class="modal-body">
                <div class="modal-body-fields">
                    <p class="text-grey"><?php echo escape($data->name); ?> is available for hire. Fill in the following details below, and this user will be contacted via email with your request. Strictly serious work inquiries only. Sending spam will result in account suspension.</p>
                    <hr>

                    <div class="field">
                        <label for="email">Your Name</label>
                        <input type="email" name="email" class="input input-text" id="email" value="<?php echo escape($user->data()->name); ?>">
                    </div>

                    <div class="field">
                        <label for="name">Your Email</label>
                        <input type="text" name="name" class="input input-text" id="name" value="<?php echo escape($user->data()->email); ?>">
                    </div>

                    <div class="field">
                        <label for="name">Your Price</label>
                        <input type="text" name="name" class="input input-text" id="name" placeholder="For example: I will pay £450 for the website.">
                    </div>

                    <div class="field">
                        <label for="about">Message</label>
                        <textarea name="about" class="input input-text input-textarea" id="about" placeholder="Explain your project."></textarea>
                    </div>

                    <input type="submit" class="button button-success" value="Send Inquiry">
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>