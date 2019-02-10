<header class="tab-subheader">
    <div class="tab-subheader-inner clearfix">
        <div class="container">
            <ul>
                <li><a href="/notifications" class="active">Notifications</a></li>
            </ul>
        </div>
    </div>
</header>

<section class="main">
    <div class="main-content bg-fix clearfix">
        <div class="container">
            <div class="notifications slate">
                <?php if(!$notification->getAllNotifications()->count()): ?>
                    <div class="no-notifications">
                        <div class="icons"><span class="ion-android-notifications"></span> <span class="ion-happy-outline"></span></div>
                        <div class="message">All caught up!<span>You have no new notifications.<span></div>
                    </div>
                <?php else: ?>
                <ul class="notifications-inner">
                    <?php foreach($notification->getAllNotifications()->results() as $n): ?>
                    <li>
                    <?php $post = new Post; $comment = new Comment; ?>
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
                </ul>
            <?php endif; ?>
            </div>
        </div>
    </div>
</section>