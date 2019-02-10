<?php
function randomSuccessMessage() {
    $m = array("Success!", "Great!", "Hooray!", "Brilliant!", "Awesome!");
    return $m[array_rand($m, 1)];
}

function randomErrorMessage() {
    $m = array("Oops.", "Oh dear.", "Whoops!", "Oh no!");
    return $m[array_rand($m, 1)];
}

function currentPage() {
    return basename($_SERVER['PHP_SELF']);
}

function linkify($s) {
    return preg_replace('|([\w\d]*)\s?(https?://([\d\w\.-]+\.[\w\.]{2,6})[^\s\]\[\<\>]*/?)|i', '$1 <a href="$2" target="_blank">$3 <span class="ion-android-open"></span></a>', $s);
}

function embedYoutube($s) {
    return preg_replace('#<a(.*?)(?:href="https?://)?(?:www\.)?(?:youtu\.be/|youtube\.com(?:/embed/|/v/|/watch?.*?v=))([\w\-]{10,12}).*<\/a>#x', '</p><div class="post-main-video"><iframe src="https://www.youtube.com/embed/$2" frameborder="0" allowfullscreen></iframe></div><p>', $s);
}

function streamPost($p, $user, $comment, $allComments = false, $compact = false) {
    ob_start();
    ?>
    <div class="post">
        <div class="post-main slate">
            <div class="post-header">
                <div class="post-user clearfix">
                    <img src="<?php echo USER_AVATAR_DIR . $user->get($p->user_id)->avatar; ?>" class="post-user-photo" alt="<?php echo $user->get($p->user_id)->name; ?>">
                    <div class="user-name-top">
                        <span class="post-user-name"><a href="<?php if($p->page): echo '/page/'; else: echo '/user/'; endif; echo $user->get($p->user_id)->username; ?>"><?php echo $user->get($p->user_id)->name; ?> <?php if($user->get($p->user_id)->verified): ?><span class="user-verified"><span class="ion-checkmark-circled"></span></span><?php endif; ?></a></span>
                    </div>
                    <div class="user-name-bottom">
                        <span>@<?php echo escape($user->get($p->user_id)->username); ?> &nbsp;&middot;&nbsp; <abbr class="timeago" title="<?php echo date(DATE_ISO8601, strtotime($p->date)); ?>"></abbr><?php if($p->edited): ?> &nbsp;&middot;&nbsp; Edited<?php endif; ?></span>
                        <span class="float-right">
                        <?php if($user->isLoggedIn()): ?>
                            <?php if($p->user_id === $user->data()->id || $user->isPageMember($p->user_id)): ?>
                                <a href="" class="show-modal text-green" name="modal-edit-<?php echo $p->id ?>"><span class="icon ion-edit"></span> Edit</a> &nbsp;&middot;&nbsp; <a href="/ajax/delete-post?post_id=<?php echo $p->id; ?>" class="delete-post"><span class="icon ion-trash-a"></span> Delete</a>
                            <?php else: ?>
                                <?php
                                $post = new Post;
                                if(!$post->isFollowing($p->id)): ?>
                                    <?php if($user->isLoggedIn()): ?>
                                    <a href="/ajax/follow-post?post_id=<?php echo $p->id; ?>" class="follow-post animated"><span class="icon ion-android-add-circle"></span> <span class="follow-post-text">Subscribe</span></a>
                                    <?php else: ?>
                                    <a href="/login?return_to=/post/<?php echo $p->id; ?>"><span class="icon ion-android-add-circle"></span> <span class="follow-post-text">Subscribe</span></a>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <a href="/ajax/unfollow-post?post_id=<?php echo $p->id; ?>" class="follow-post animated"><span class="icon ion-android-remove-circle"></span> <span class="follow-post-text">Unsubscribe</span></a>
                                <?php endif; ?>
                                 &nbsp;&middot;&nbsp; <a href="/ajax/report-post?post_id=<?php echo $p->id; ?>" class="report-post"><span class="icon ion-flag"></span> Report</a>
                            <?php endif; ?>
                        <?php endif; ?>
                        </span>
                    </div>
                </div>
            </div>

            <div class="post-main-text">
                <p><?php echo $text = Hashmention::parse(embedYoutube(linkify(nl2br(escapeFormatting($p->content))))); ?></p>
                <?php if($p->photo): ?>
                <div class="post-main-photo">
                    <a href="" class="show-modal" name="<?php echo 'modal-photo-' . $p->id; ?>">
                        <img src="<?php echo POST_DIR . $p->photo; ?>" alt="<?php echo $user->get($p->user_id)->name ?>'s Photo">
                        <?php if(substr(strrchr($p->photo, '.'), 1) === 'gif'): ?><div class="photo-gif">GIF<span>CLICK TO SHOW GIF ANIMATION</span></div><?php endif; ?>
                    </a>
                </div>
                <?php endif; ?>
            </div>
            <div class="post-main-footer">
                <div class="post-comments-actions clearfix">
                    <div class="float-left">
                        <?php
                        $like = new Like;
                        if(!$like->hasLiked($p->id)): ?>  
                            <?php if($user->isLoggedIn()): ?>
                            <a href="/ajax/like?post_id=<?php echo $p->id; ?>" class="like-post animated"><span class="ion-heart"></span> <span class="like-post-text">Like</span></a>
                            <?php else: ?>
                            <a href="/login?return_to=/user/<?php echo $user->get($p->user_id)->username; ?>"><span class="ion-heart"></span> <span class="like-post-text">Like</span></a>
                            <?php endif; ?>
                        <?php else: ?>
                            <a href="/ajax/unlike?post_id=<?php echo $p->id; ?>" class="like-post text-red animated"><span class="ion-heart"></span> <span class="like-post-text">Unlike</span></a>
                        <?php endif; ?>
                        <a href=""><label for="comment-<?php echo $p->id ?>"><span class="ion-chatboxes"></span> Comment</label></a>
                    </div>
                    <div class="float-right">
                        <a href="" class="show-modal" name="<?php echo 'modal-likes-' . $p->id; ?>"><span class="like-count"><?php echo DB::getInstance()->get('likes', array('post_id', '=', $p->id))->count(); ?> like<?php echo DB::getInstance()->get('likes', array('post_id', '=', $p->id))->count() === 1 ? '' : 's'; ?></span></a>
                        <a href="/post/<?php echo $p->id; ?>"><span class="comment-count"><?php echo $comment->getAllPostComments($p->id)->count(); ?></span> comment<?php echo $comment->getAllPostComments($p->id)->count() === 1 ? '' : 's'; ?></a>
                    </div>
                </div>
                <?php if($compact === false): ?>
                <?php if($user->isLoggedIn()): ?>
                <div class="post-comments-comment">
                    <form method="post" name="comment-form" class="comment-form">
                        <div class="post-comment clearfix">
                            <div class="post-comment-left float-left">
                                <img src="<?php echo USER_AVATAR_DIR . $user->data()->avatar; ?>" alt="<?php echo escape($user->data()->name); ?>">
                            </div>
                            <div class="post-comment-right">
                                <textarea name="comment" class="input input-text input-full-width input-comment" id="comment-<?php echo $p->id; ?>" placeholder="What are your thoughts?" onkeyup="auto_grow(this)" autocomplete="off"></textarea>
                                <input type="hidden" name="post_id" value="<?php echo $p->id; ?>">
                            </div>
                        </div>

                        <div class="new-comment"></div>
                    </form>
                </div>
                <?php endif; ?>
                <div class="post-comments">
                <?php
                if($comment->getAllPostComments($p->id)->count()) {
                    if($allComments === true) {
                        foreach($comment->getAllPostComments($p->id)->results() as $c) {
                            echo streamPostComment($p, $c, $user);
                        }
                    } else {
                        foreach($comment->getPostComments($p->id)->results() as $c) {
                            echo streamPostComment($p, $c, $user);
                        }
                    }
                }
                ?>
                </div>
                <?php if($comment->getAllPostComments($p->id)->count() > 4 && $allComments === false): ?>
                <div class="post-view-more">
                    <a href="/post/<?php echo $p->id; ?>"><span class="ion-chatboxes"></span> View <?php echo $comment->getAllPostComments($p->id)->count() - 4; ?> more comment<?php echo $comment->getAllPostComments($p->id)->count() - 4 === 1 ? '' : 's'; ?></a>
                </div>
                <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>

        <?php if($comment->getAllPostComments($p->id)->count()) { foreach($comment->getAllPostComments($p->id)->results() as $c) { ?>
        <div class="modal" id="<?php echo 'modal-edit-comment-' . $c->id; ?>">
            <div class="modal-shade"></div>
            <div class="modal-container">
                <div class="modal-container-inner">
                    <div class="modal-header clearfix">
                        <div class="float-left">Edit Comment</div>
                        <div class="float-right"><a href="" class="close-modal"><span class="ion-close"></span></a></div>
                    </div>
                    <div class="modal-body">
                        <div class="modal-body-edit">
                            <div class="comment-text-editor">
                                <form method="post" name="edit-comment-form" class="edit-comment-form">
                                    <textarea name="comment" class="input post-input post-edit-input" tabindex="2" maxlength="800"><?php echo escape($c->content); ?></textarea>
                                    <button type="submit" class="button button-small button-success"><span class="ion-edit">&nbsp;</span> Finish Editing</button>
                                    <input type="hidden" class="post-id" name="post_id" value="<?php echo $p->id; ?>">
                                    <input type="hidden" class="comment-id" name="comment_id" value="<?php echo $c->id; ?>">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } } ?>

        <div class="modal" id="<?php echo 'modal-edit-' . $p->id; ?>">
            <div class="modal-shade"></div>
            <div class="modal-container">
                <div class="modal-container-inner">
                    <div class="modal-header clearfix">
                        <div class="float-left">Edit Post</div>
                        <div class="float-right"><a href="" class="close-modal"><span class="ion-close"></span></a></div>
                    </div>
                    <div class="modal-body">
                        <div class="modal-body-edit">
                            <div class="post-text-editor">
                                <form method="post" name="edit-post-form" class="edit-post-form">
                                    <textarea name="post" class="input post-input post-edit-input" tabindex="2" maxlength="800"><?php echo escape($p->content); ?></textarea>
                                    <button type="submit" class="button button-small button-success"><span class="ion-edit">&nbsp;</span> Finish Editing</button>
                                    <input type="hidden" class="post-id" name="post_id" value="<?php echo $p->id; ?>">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php if($p->photo): ?>
        <div class="modal modal-full" id="<?php echo 'modal-photo-' . $p->id; ?>">
            <div class="modal-shade"></div>
            <div class="modal-container">
                <div class="modal-container-inner">
                    <div class="modal-header clearfix">
                        <div class="float-left"><?php echo $user->get($p->user_id)->name ?>'s Photo</div>
                        <div class="float-right"><a href="" class="close-modal"><span class="ion-close"></span></a></div>
                    </div>
                    <div class="modal-body">
                        <img src="<?php echo POST_FS_DIR . $p->photo; ?>" alt="<?php echo $user->get($p->user_id)->name ?>'s Photo">
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <?php if(DB::getInstance()->get('likes', array('post_id', '=', $p->id))->count()): ?>
        <div class="modal" id="<?php echo 'modal-likes-' . $p->id; ?>">
            <div class="modal-shade"></div>
            <div class="modal-container">
                <div class="modal-container-inner">
                    <div class="modal-header clearfix">
                        <div class="float-left">People who like this</div>
                        <div class="float-right"><a href="" class="close-modal"><span class="ion-close"></span></a></div>
                    </div>
                    <div class="modal-body">
                        <div class="modal-body-users">
                            <ul>
                                <?php
                                foreach(DB::getInstance()->get('likes', array('post_id', '=', $p->id))->results() as $l):
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
                                                            <a href="<?php echo APP_URL; ?>user/<?php echo escape($user->get($l->user_id)->username); ?>?action=unfollow" class="button button-warning button-tiny"><span class="ion-person-add">&nbsp;</span> Unfollow</a>
                                                        <?php } else { ?>
                                                            <a href="<?php echo APP_URL; ?>user/<?php echo escape($user->get($l->user_id)->username); ?>?action=follow" class="button button-success button-tiny"><span class="ion-person-add">&nbsp;</span> Follow</a>
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
    </div>
    <?php
    $html = ob_get_contents();
    ob_end_clean();

    return $html;
}

function streamPostComment($p, $c, $user, $new = null) {
    ob_start();
    ?>
    <div class="post-comment" id="comment-<?php echo $c->id; ?>">
        <div class="post-comment-main clearfix">
            <div class="post-comment-left float-left">
                <img src="<?php echo USER_AVATAR_DIR . $user->get($c->user_id)->avatar; ?>" alt="<?php echo $user->get($c->user_id)->name; ?>">
            </div>
            <div class="post-comment-right">
                <h4><a href="<?php echo '/user/' . $user->get($c->user_id)->username; ?>"><?php echo $user->get($c->user_id)->name; ?> <?php if($user->get($c->user_id)->verified): ?><span class="user-verified"><span class="ion-checkmark-circled"></span></span><?php endif; ?></a></h4>
                <p><?php echo Hashmention::parse(linkify(escapeFormatting($c->content))); ?></b></i></s></pre></p>
                <p class="posted">
                    <span class="float-left">
                        @<?php echo escape($user->get($c->user_id)->username); ?> &nbsp;&middot;&nbsp; <?php if($new === true): ?>just now<?php else: ?><abbr class="timeago" title="<?php echo date(DATE_ISO8601, strtotime($c->date)); ?>"></abbr><?php endif; ?><?php if($c->edited): ?> &nbsp;&middot;&nbsp; Edited<?php endif; ?> &nbsp;&middot;&nbsp; 
                        <?php
                        $like = new Like;
                        if(!$like->hasLikedComment($c->id)): ?>
                            <?php if($user->isLoggedIn()): ?>
                            <a href="/ajax/like-comment?comment_id=<?php echo $c->id; ?>" class="like-comment animated"><span class="icon ion-heart"></span> <span class="like-comment-text">Like</span></a>
                            <?php else: ?>
                            <a href="/login?return_to=/user/<?php echo $user->get($c->user_id)->username; ?>"><span class="icon ion-heart"></span> <span class="like-comment-text">Like</span></a>
                            <?php endif; ?>
                        <?php else: ?>
                            <a href="/ajax/unlike-comment?comment_id=<?php echo $c->id; ?>" class="like-comment text-red animated"><span class="icon ion-heart"></span> <span class="like-comment-text">Unlike</span></a>
                        <?php endif; ?>
                        (<span class="comment-like-count"><?php echo DB::getInstance()->get('comment_likes', array('comment_id', '=', $c->id))->count(); ?></span>)
                    </span>
                    <span class="float-right">
                    <?php if($new !== true) { ?>
                        <?php if($user->isLoggedIn()): ?>
                            <?php if($c->user_id !== $user->data()->id): ?><a href="" class="reply-comment" data-id="<?php echo $p->id; ?>" data-val="<?php echo $user->get($c->user_id)->username; ?>"><span class="icon ion-reply"></span> Reply</a> &nbsp;&middot;&nbsp; <?php endif; ?>
                            <?php if($c->user_id === $user->data()->id): ?>
                                <a href="" class="show-modal text-green" name="modal-edit-comment-<?php echo $c->id ?>"><span class="icon ion-edit"></span> Edit</a> &nbsp;&middot;&nbsp; <a href="/ajax/delete-comment?comment_id=<?php echo $c->id; ?>" class="delete-comment"><span class="delete-comment-text"><span class="icon ion-trash-a"></span> Delete</span></a>
                            <?php else: ?>
                                <a href="/ajax/report-comment?comment_id=<?php echo $c->id; ?>" class="report-comment"><span class="icon ion-flag"></span> Report</a>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php } ?>
                    </span>
                </p>
            </div>
        </div>
    </div>
    <?php
    $html = ob_get_contents();
    ob_end_clean();

    return $html;
}