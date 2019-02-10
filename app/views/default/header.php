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

<?php if($user->isLoggedIn() && $user->data()->active == 0): ?>
<div class="messages bg-fix">
    <div class="message message-info">
        <span class="ion-information-circled"></span> Confirm your email address to access all of CraftedIn's features. A confirmation message was sent to <?php echo $user->data()->email ?>. <a href="/activate?resend=true">Resend email</a>.
        <div class="message-close float-right"><a href=""><span class="ion-close"></span></a></div>
    </div>
</div>
<?php endif; ?>

<header class="header bg-fix<?php if(isset($hero) === true): ?> header-clear<?php endif; ?>">
    <div class="main-nav">
        <div class="container">
            <div class="nav-inner clearfix">
                <div class="float-left">
                    <div class="nav-logo">
                        <a href="<?php echo APP_URL; ?>" title="CraftedIn"><div class="logo-inner">CraftedIn</div></a>
                        <?php if($user->isLoggedIn() && $user->isPremium()): ?><a href="/plus" class="logo-plus"><span class="tag tag-green">Plus</span></a><?php endif; ?>
                    </div>

                    <div class="nav-search">
                        <div class="search-bar">
                            <form action="/search" method="get">
                                <button type="submit" class="search-bar-button<?php if(isset($hero) === true): ?> search-hero<?php endif; ?>"><span class="ion-android-search"></span></button>
                                <input type="text" name="q" class="search-bar-input<?php if(isset($hero) === true): ?> search-hero<?php endif; ?>" placeholder="Search for people, posts and more" autocomplete="off" tabindex="1" id="search-autosuggest" <?php if(Input::get('q') !== null): echo 'value="' . escape(Input::get('q')) . '"'; endif; ?>>
                            </form>
                            <ul id="search-autosuggest-list" class="search-autosuggest-list"></ul>
                        </div>
                    </div>
                </div>

                <div class="float-right">
                    <?php if($user->isLoggedIn()) { ?>
                    <?php if($user->hasPermission('moderator')): ?>
                    <div class="nav-user-moderator">
                        <a href="/moderator" class="moderator-dropdown-toggle" title="Moderator">
                            <div class="moderator-icon"><span class="ion-settings"></span></div>
                            <?php if($moderator->getUnacted()): ?><div class="moderator-badge"><?php echo $moderator->getUnacted(); ?></div><?php endif; ?>
                        </a>
                    </div>
                    <?php endif; ?>

                    <div class="nav-user-pages">
                        <a href="/pages" class="pages-dropdown-toggle" title="CraftedIn Pages">
                            <div class="pages-icon"><span class="ion-android-send"></span></div>
                        </a>
                    </div>

                    <div class="nav-user-messages">
                        <a href="#" class="messages-dropdown-toggle" title="Messages">
                            <div class="message-icon"><span class="ion-android-drafts"></span></div>
                            <?php if($message->getUnreadMessages()->count()): ?><div class="message-badge"><?php echo $message->getUnreadMessages()->count(); ?></div><?php endif; ?>
                        </a>

                        <div class="messages-dropdown user-notifications-dropdown">
                            <div class="dropdown-caret">
                                <div class="caret-fill"></div>
                            </div>
                            <div class="dropdown-body">
                                <div class="dropdown-header clearfix">
                                    <div class="float-left">
                                        Messages
                                    </div>
                                </div>
                                <?php if(!$message->getMessages()->count()): ?>
                                    <div class="no-notifications">
                                        <div class="icons"><span class="ion-email"></span> <span class="ion-happy-outline"></span></div>
                                        <div class="message">All caught up!<span>You have no new messages.<span></div>
                                    </div>
                                <?php else: ?>
                                <ul>
                                    <?php foreach($message->getFiveMessages()->results() as $m): ?>
                                    <li>
                                        <a href="<?php echo '/messages/inbox?read=' . $m->id; ?>" class="clearfix <?php if($m->seen === '0') { echo 'new'; } ?>">
                                            <div class="float-left">
                                                <img src="<?php echo USER_AVATAR_DIR . $user->get($m->sender_user_id)->avatar; ?>" alt="<?php echo escape($user->get($m->sender_user_id)->name); ?>">
                                            </div>
                                            <div class="float-right">
                                                <strong>"<?php echo substr(escape($m->subject), 0, 50); ?>"</strong><br>
                                                from <strong><?php echo escape($user->get($m->sender_user_id)->name); ?></strong>
                                                <div class="time"><span class="ion-archive text-blue">&nbsp;</span> <abbr class="timeago" title="<?php echo date(DATE_ISO8601, strtotime($m->date)); ?>"></abbr></div>
                                            </div>
                                        </a>
                                    </li>
                                    <?php endforeach; ?>
                                    <li>
                                        <a href="/messages/inbox" class="view-all">
                                            <span class="ion-email"></span> Go to Inbox
                                        </a>
                                    </li>
                                </ul>
                            <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="nav-user-notifications">
                        <a href="#" class="notifications-dropdown-toggle" id="notifications-dropdown-toggle" title="Notifications">
                            <div class="notification-icon"><span class="ion-android-notifications"></span></div>
                            <?php if($notification->getUnreadNotifications()->count()): ?><div class="notification-badge"><?php echo $notification->getUnreadNotifications()->count(); ?></div><?php endif; ?>
                        </a>

                        <div class="notifications-dropdown user-notifications-dropdown">
                            <div class="dropdown-caret">
                                <div class="caret-fill"></div>
                            </div>
                            <div class="dropdown-body">
                                <div class="dropdown-header clearfix">
                                    <div class="float-left">
                                        Notifications
                                    </div>
                                </div>
                                <?php if(!$notification->getNotifications()->count()): ?>
                                    <div class="no-notifications">
                                        <div class="icons"><span class="ion-android-notifications"></span> <span class="ion-happy-outline"></span></div>
                                        <div class="message">All caught up!<span>You have no new notifications.<span></div>
                                    </div>
                                <?php else: ?>
                                <ul>
                                    <?php foreach($notification->getNotifications()->results() as $n): ?>
                                    <li>
                                     <?php if($n->type === 'comments'): ?>
                                        <a href="<?php echo '/post/' . escape($n->type_id); ?>" class="clearfix <?php if($n->seen === '0') { echo 'new'; } ?>">
                                            <div class="float-left">
                                                <img src="<?php echo USER_AVATAR_DIR . $user->get($n->actor_user_id)->avatar; ?>" alt="<?php echo escape($user->get($n->actor_user_id)->name); ?>">
                                            </div>
                                            <div class="float-right">
                                                <strong><?php echo escape($user->get($n->actor_user_id)->name); ?></strong> commented on <?php if($n->recipient_user_id <> $user->data()->id): echo '<strong>' . escape($user->get($n->recipient_user_id)->name) . '\'s</strong>'; else: echo 'your'; endif; ?> post.
                                                <div class="time"><span class="ion-chatbubble text-green">&nbsp;</span> <abbr class="timeago" title="<?php echo date(DATE_ISO8601, strtotime($n->date)); ?>"></abbr></div>
                                            </div>
                                        </a>
                                    <?php elseif($n->type === 'post_following'): ?>
                                        <a href="<?php echo '/post/' . escape($n->type_id); ?>" class="clearfix <?php if($n->seen === '0') { echo 'new'; } ?>">
                                            <div class="float-left">
                                                <img src="<?php echo USER_AVATAR_DIR . $user->get($n->actor_user_id)->avatar; ?>" alt="<?php echo escape($user->get($n->actor_user_id)->name); ?>">
                                            </div>
                                            <div class="float-right">
                                                <strong><?php echo escape($user->get($n->actor_user_id)->name); ?></strong> also commented on <strong><?php echo $user->get($post->get($n->type_id)->user_id)->name ?>'s</strong> post.
                                                <div class="time"><span class="ion-chatbubble text-green">&nbsp;</span> <abbr class="timeago" title="<?php echo date(DATE_ISO8601, strtotime($n->date)); ?>"></abbr></div>
                                            </div>
                                        </a>
                                    <?php elseif($n->type === 'following'): ?>
                                        <a href="<?php echo '/user/' . escape($user->get($n->actor_user_id)->username); ?>" class="clearfix <?php if($n->seen === '0') { echo 'new'; } ?>">
                                            <div class="float-left">
                                                <img src="<?php echo USER_AVATAR_DIR . $user->get($n->actor_user_id)->avatar; ?>" alt="<?php echo escape($user->get($n->actor_user_id)->name); ?>">
                                            </div>
                                            <div class="float-right">
                                                <strong><?php echo escape($user->get($n->actor_user_id)->name); ?></strong> is now following <?php if($n->recipient_user_id <> $user->data()->id): echo '<strong>' . escape($user->get($n->recipient_user_id)->name) . '</strong>'; else: echo 'you'; endif; ?>!
                                                <div class="time"><span class="ion-person-add text-green">&nbsp;</span> <abbr class="timeago" title="<?php echo date(DATE_ISO8601, strtotime($n->date)); ?>"></abbr></div>
                                            </div>
                                        </a>
                                    <?php elseif($n->type === 'likes'): ?>
                                        <a href="<?php echo '/post/' . escape($n->type_id); ?>" class="clearfix <?php if($n->seen === '0') { echo 'new'; } ?>">
                                            <div class="float-left">
                                                <img src="<?php echo USER_AVATAR_DIR . $user->get($n->actor_user_id)->avatar; ?>" alt="<?php echo escape($user->get($n->actor_user_id)->name); ?>">
                                            </div>
                                            <div class="float-right">
                                                <strong><?php echo escape($user->get($n->actor_user_id)->name); ?></strong> liked <?php if($n->recipient_user_id <> $user->data()->id): echo '<strong>' . escape($user->get($n->recipient_user_id)->name) . '\'s</strong>'; else: echo 'your'; endif; ?> post.
                                                <div class="time"><span class="ion-heart text-red">&nbsp;</span> <abbr class="timeago" title="<?php echo date(DATE_ISO8601, strtotime($n->date)); ?>"></abbr></div>
                                            </div>
                                        </a>
                                    <?php elseif($n->type === 'comment_likes'): ?>
                                        <a href="<?php echo '/post/' . $comment->getPostId(escape($n->type_id)) . '#comment-' . escape($n->type_id); ?>" class="clearfix <?php if($n->seen === '0') { echo 'new'; } ?>">
                                            <div class="float-left">
                                                <img src="<?php echo USER_AVATAR_DIR . $user->get($n->actor_user_id)->avatar; ?>" alt="<?php echo escape($user->get($n->actor_user_id)->name); ?>">
                                            </div>
                                            <div class="float-right">
                                                <strong><?php echo escape($user->get($n->actor_user_id)->name); ?></strong> liked your comment.
                                                <div class="time"><span class="ion-heart text-red">&nbsp;</span> <abbr class="timeago" title="<?php echo date(DATE_ISO8601, strtotime($n->date)); ?>"></abbr></div>
                                            </div>
                                        </a>
                                    <?php elseif($n->type === 'post_mention'): ?>
                                        <a href="<?php echo '/post/' . escape($n->type_id); ?>" class="clearfix <?php if($n->seen === '0') { echo 'new'; } ?>">
                                            <div class="float-left">
                                                <img src="<?php echo USER_AVATAR_DIR . $user->get($n->actor_user_id)->avatar; ?>" alt="<?php echo escape($user->get($n->actor_user_id)->name); ?>">
                                            </div>
                                            <div class="float-right">
                                                <strong><?php echo escape($user->get($n->actor_user_id)->name); ?></strong> mentioned <?php if($n->recipient_user_id <> $user->data()->id): echo '<strong>' . escape($user->get($n->recipient_user_id)->name) . '\'s</strong>'; else: echo 'you'; endif; ?> in a post.
                                                <div class="time"><span class="ion-at text-blue">&nbsp;</span> <abbr class="timeago" title="<?php echo date(DATE_ISO8601, strtotime($n->date)); ?>"></abbr></div>
                                            </div>
                                        </a>
                                    <?php elseif($n->type === 'comment_mention'): ?>
                                        <a href="<?php echo '/post/' . escape($n->type_id); ?>" class="clearfix <?php if($n->seen === '0') { echo 'new'; } ?>">
                                            <div class="float-left">
                                                <img src="<?php echo USER_AVATAR_DIR . $user->get($n->actor_user_id)->avatar; ?>" alt="<?php echo escape($user->get($n->actor_user_id)->name); ?>">
                                            </div>
                                            <div class="float-right">
                                                <strong><?php echo escape($user->get($n->actor_user_id)->name); ?></strong> mentioned <?php if($n->recipient_user_id <> $user->data()->id): echo '<strong>' . escape($user->get($n->recipient_user_id)->name) . '</strong>'; else: echo 'you'; endif; ?> in a comment.
                                                <div class="time"><span class="ion-at text-blue">&nbsp;</span> <abbr class="timeago" title="<?php echo date(DATE_ISO8601, strtotime($n->date)); ?>"></abbr></div>
                                            </div>
                                        </a>
                                    <?php elseif($n->type === 'team_members'): ?>
                                        <a href="<?php echo '/user/' . escape($user->get($n->actor_user_id)->username); ?>" class="clearfix <?php if($n->seen === '0') { echo 'new'; } ?>">
                                            <div class="float-left">
                                                <img src="<?php echo USER_AVATAR_DIR . $user->get($n->actor_user_id)->avatar; ?>" alt="<?php echo escape($user->get($n->actor_user_id)->name); ?>">
                                            </div>
                                            <div class="float-right">
                                                <strong><?php echo escape($user->get($n->actor_user_id)->name); ?></strong> added you to their page.
                                                <div class="time"><span class="ion-plus text-green">&nbsp;</span> <abbr class="timeago" title="<?php echo date(DATE_ISO8601, strtotime($n->date)); ?>"></abbr></div>
                                            </div>
                                        </a>
                                    <?php endif; ?>
                                    </li>
                                    <?php endforeach; ?>
                                    <li>
                                        <a href="/notifications" class="view-all">
                                            <span class="ion-android-notifications"></span> View All Notifications
                                        </a>
                                    </li>
                                </ul>
                            <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="nav-user">
                        <a href="#" class="user-dropdown-toggle" title="<?php echo escape($user->data()->name); ?>">
                            <div class="user-img">
                                <img src="<?php echo USER_AVATAR_DIR . $user->data()->avatar; ?>" alt="<?php echo escape($user->data()->name); ?>">
                            </div>
                        </a>

                        <div class="user-dropdown">
                            <div class="dropdown-caret">
                                <div class="caret-fill"></div>
                            </div>
                            <div class="dropdown-body">
                                <ul>
                                    <li><a href="<?php echo APP_URL; ?>user/<?php echo $user->data()->username ?>"><span class="ion-person"></span> View Profile</a></li>
                                    <li class="dropdown-spacer"></li>
                                    <li><a href="<?php echo APP_URL; ?>messages/inbox"><span class="ion-android-drafts"></span> Inbox</a></li>
                                    <li><a href="<?php echo APP_URL; ?>messages/sent"><span class="ion-paper-airplane"></span> Sent</a></li>
                                    <li><a href="<?php echo APP_URL; ?>messages/compose"><span class="ion-android-create"></span> Compose</a></li>
                                    <li class="dropdown-spacer"></li>
                                    <li><a href="<?php echo APP_URL; ?>account/settings"><span class="ion-gear-a"></span> Settings</a></li>
                                    <li><a href="<?php echo APP_URL; ?>account/password"><span class="ion-android-lock"></span> Change Password</a></li>
                                    <li><a href="<?php echo APP_URL; ?>account/pictures"><span class="ion-android-image"></span> Change Pictures</a></li>
                                    <li><a href="<?php echo APP_URL; ?>account/security"><span class="ion-android-expand"></span> Sessions</a></li>
                                    <li class="dropdown-spacer"></li>
                                    <?php if($user->isPremium()): ?>
                                    <li><a href="<?php echo APP_URL; ?>plus"><span class="ion-plus"></span> Your Plus</a></li>
                                    <?php else: ?>
                                    <li><a href="<?php echo APP_URL; ?>plus"><span class="ion-plus"></span> Upgrade to Plus</a></li>
                                    <?php endif; ?>
                                    <li class="dropdown-spacer"></li>
                                    <li><a href="<?php echo APP_URL; ?>logout" class="text-red"><span class="ion-android-exit"></span> Log Out</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <?php } else { ?>
                    <div class="nav-user-new">
                        <a href="<?php echo APP_URL; ?>login" class="button user-login">Log in</a>
                        <a href="<?php echo APP_URL; ?>signup" class="button user-signup">Sign up</a>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</header>