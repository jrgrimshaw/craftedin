<section class="main">
    <div class="main-content bg-fix clearfix">
        <div class="container">
            <div class="content-main">
                <div class="search">
                    <div class="search-header">
                        Results for <strong>"<?php echo $q; ?>"</strong>
                    </div>

                    <div class="search-time">
                        Found <strong><?php echo $resultsCount; ?></strong> result<?php if($resultsCount !== 1): ?>s<?php endif; ?> in <strong><?php echo $time; ?></strong> seconds
                    </div>

                    <div class="search-body">
                        <div class="search-top clearfix">
                            <div class="search-area area-left slate">
                                <h2>People</h2>

                                <?php if($peopleRowsCount): ?>
                                    <?php foreach($peopleRows as $r): ?>
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
                                                    } ?>
                                                </div>
                                            </h3>

                                            <div class="user-info">
                                                <?php if($r->job != null) { ?><p class="job"><span class="ion-briefcase"></span> <?php echo escape($r->job); ?></p>
                                                <?php } elseif($r->location != null) { ?><p><span class="ion-location"></span> <?php echo escape($r->location); ?></p>
                                                <?php } else { ?><p><span class="ion-clock"></span> Joined <?php echo date("F Y", strtotime($r->joined)); ?></p><?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                <div class="no-posts">
                                    <div class="message"><strong><span class="ion-sad-outline">&nbsp;</span> There are no people that match "<?php echo $q; ?>".</strong></div>
                                </div>
                                <?php endif; ?>
                            </div>

                            <div class="search-area area-right slate">
                                <h2>Pages</h2>

                                <?php if($pageRowsCount): ?>
                                    <?php foreach($pageRows as $r): ?>
                                    <div class="user clearfix">
                                        <div class="user-left float-left">
                                            <img src="<?php echo USER_AVATAR_DIR . $r->avatar; ?>" alt="<?php escape($r->name); ?>">
                                        </div>
                                        <div class="user-right">
                                            <h3>
                                                <a href="<?php echo '/page/' . escape($r->username); ?>"><?php echo escape($r->name); ?> <?php if($r->verified): ?><span class="user-verified"><span class="ion-checkmark-circled"></span></span><?php endif; ?></a>
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
                                                    } ?>
                                                </div>
                                            </h3>

                                            <div class="user-info">
                                                <?php if($r->job != null) { ?><p class="job"><span class="ion-briefcase"></span> <?php echo escape($r->job); ?></p>
                                                <?php } elseif($r->location != null) { ?><p><span class="ion-location"></span> <?php echo escape($r->location); ?></p>
                                                <?php } else { ?><p><span class="ion-clock"></span> Joined <?php echo date("F Y", strtotime($r->joined)); ?></p><?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                <div class="no-posts">
                                    <div class="message"><strong><span class="ion-sad-outline">&nbsp;</span> There are no pages that match "<?php echo $q; ?>".</strong></div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="search-bottom">
                            <div class="search-posts slate">
                                <h2>Posts</h2>
                            </div>

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
                                    <div class="message"><strong>There are no posts that match "<?php echo $q; ?>".</strong></div>
                                </div>
                                <?php
                            }
                            ?>
                            <script>
                                loadmore('/ajax/posts?type=search&q=<?php echo urlencode($q); ?>');
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>