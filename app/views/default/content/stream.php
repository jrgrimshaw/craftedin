<header class="tab-subheader">
    <div class="tab-subheader-inner clearfix">
        <div class="container">
            <ul class="inline-block">
                <li><a href="/stream" class="active active-red"><span class="ion-android-funnel"></span> Stream</a></li>
                <li><a href="/explore"><span class="ion-ios-pulse-strong"></span> Popular</a></li>
                <li><a href="/explore/new"><span class="ion-android-time"></span> Recent</a></li>
            </ul>
        </div>
    </div>
</header>

<section class="main">
    <div class="main-content bg-fix clearfix">
        <div class="container">
            <div class="content-sidebar float-right">
                <?php
                echo sidebarTotd();
                echo sidebarDonate();
                echo sidebarWtf($user);
                echo sidebarPopular();
                echo sidebarAd();
                ?>
            </div>

            <div class="content-main">
                <div class="stream">
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
                                            <option value="<?php echo $user->data()->id; ?>" selected>Post as myself</option>
                                            <?php foreach($user->getPages()->results() as $p): ?>
                                            <option value="<?php echo $p->page_id; ?>">Post as <?php echo $user->get($p->page_id)->name; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <span class="post-characters-remaining">5000</span>
                                        <button type="submit" class="button button-primary"><span class="ion-paper-airplane">&nbsp;</span> Post</button>
                                    </div>
                                </div>
                                <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                            </form>
                        </div>
                    </div>

                    <?php
                    if($postsCount) {
                        ?>
                        <div class="posts"></div>

                        <?php if($postsCount >= 15): ?>
                        <a href="" class="posts-load button"><span class="ion-loop"></span> Load more</a>
                        <?php else: ?>
                        <div class="no-posts">
                            <div class="icon ion-sad-outline"></div>
                            <div class="message"><strong>That's all folks!</strong><br>Try following more people.</div>
                        </div>
                        <?php endif; ?>
                        <?php
                    } else {
                        ?>
                        <div class="no-posts">
                            <div class="icon ion-sad-outline"></div>
                            <div class="message"><strong>There are no posts to show in your stream.</strong><br>Try following more people.</div>
                        </div>
                        <?php
                    }
                    ?>

                    <script>
                        loadmore('/ajax/posts?type=stream');
                    </script>
                </div>
            </div>
        </div>
    </div>
</section>