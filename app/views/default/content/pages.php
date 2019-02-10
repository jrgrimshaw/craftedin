<header class="tab-subheader">
    <div class="tab-subheader-inner clearfix">
        <div class="container">
            <div class="float-left">
                <ul>
                    <li><a href="/pages" class="active">Pages Manager</a></li>
                </ul>
            </div>

            <div class="float-right">
                <a href="" class="button button-success button-small show-modal" name="modal-create"><span class="ion-plus">&nbsp;</span> Create a Page</a>
            </div>
        </div>
    </div>
</header>

<section class="main">
    <div class="main-content bg-fix clearfix">
        <div class="container">
            <div class="content-sidebar float-right">
                <div class="sidebar-widget">
                    <div class="widget-header">
                        <h3>
                            <span class="icon ion-stats-bars"></span> Statistics
                        </h3>
                    </div>

                    <div class="widget-body clearfix">
                        <div class="widget-list">
                            <p><span class="ion-android-send"></span> <strong><?php echo $totalPages; ?></strong> Pages</p>
                            <p><span class="ion-android-funnel"></span> <strong><?php echo $totalPosts; ?></strong> Posts</p>
                            <p><span class="ion-person-stalker"></span> <strong><?php echo $totalFollowers; ?></strong> Followers</p>
                            <p><span class="ion-eye"></span> <strong><?php echo $totalViews; ?></strong> Views</p>
                        </div>
                    </div>
                </div>

                <?php echo sidebarAd(); ?>
            </div>

            <div class="content-main">
            <?php if($user->getPages()->count()): ?>
                <?php foreach($user->getPages()->results() as $page): ?>
                <a href="/page/<?php echo $user->get($page->page_id)->username; ?>"><div class="pages-page slate" style="background-image:url(<?php echo USER_HEADER_DIR . $user->get($page->page_id)->header; ?>)">
                    <div class="pages-page-filter">
                        <div class="pages-page-background">
                            <img src="<?php echo USER_AVATAR_DIR . $user->get($page->page_id)->avatar; ?>" alt="<?php echo $user->get($page->page_id)->name; ?>">
                        </div>
                        <div class="pages-page-main">
                            <h3><?php echo $user->get($page->page_id)->name; ?></h3>
                            <p>@<?php echo $user->get($page->page_id)->username; ?></p>
                        </div>
                        <div class="float-right">
                            <?php if($user->isPageOwner($page->page_id)): ?>
                            <div class="tag tag-orange">Owner</div>
                            <?php else: ?>
                            <div class="tag tag-grey">Editor</div>
                            <?php endif; ?>
                            <p class="text-grey"><strong><?php echo DB::getInstance()->get('following', array('user_following_id', '=', $page->page_id))->count(); ?></strong> Followers</p>
                            <p class="text-grey"><strong><?php echo $user->get($page->page_id)->views; ?></strong> Views</p>
                        </div>
                    </div>
                </div></a>
                <?php endforeach; ?>
                <div class="pages-end">
                    <span class="ion-android-send"></span>
                </div>
            <?php else: ?>
                <div class="pages slate">
                    <div class="no-pages">
                        <span class="ion-android-send"></span>
                        <p>Start building your audience.</p>
                        <a href="" class="button button-success show-modal" name="modal-create">Create a Page</a>
                    </div>
                </div>
            <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<div class="modal" id="modal-create"<?php if(Input::get('create')): ?> style="display:block;"<?php endif; ?>>
    <div class="modal-shade"></div>
    <div class="modal-container"<?php if(Input::get('create')): ?> style="display:block;"<?php endif; ?>>
        <div class="modal-container-inner">
            <div class="modal-header clearfix">
                <div class="float-left">Create a Page</div>
                <div class="float-right"><a href="" class="close-modal"><span class="ion-close"></span></a></div>
            </div>
            <div class="modal-body">
                <div class="modal-body-fields">
                    <p class="text-grey">Creating a page is easy and only takes around 15 seconds.</p>
                    <hr>

                    <form action="" method="post">
                        <div class="field">
                            <label for="username">Page Handle</label>
                            <input type="text" name="username" id="username" maxlength="15" class="input input-text url-input" autofocus>
                            <div class="url-preview">craftedin.co/page/</div>
                        </div>

                        <div class="field">
                            <label for="name">Page Name</label>
                            <input type="text" name="name" class="input input-text" maxlength="28" id="name">
                        </div>

                        <div class="field">
                            <label for="about">About</label>
                            <textarea name="about" class="input input-text input-textarea" id="about" maxlength="300" placeholder="Briefly describe your page."></textarea>
                        </div>

                        <input type="submit" class="button button-success" value="Create Page">
                        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>