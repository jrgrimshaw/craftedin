<header class="tab-subheader tab-subheader-explore<?php if(Input::get('page') === 'new'): ?> breaking<?php endif; ?>">
    <div class="tab-subheader-inner clearfix">
        <div class="container">
            <ul>
                <li><a href="/stream"><span class="ion-android-funnel"></span> Stream</a></li>
                <li><a href="/explore"<?php if(Input::get('page') !== 'new'): ?> class="active active-green"<?php endif; ?>><span class="ion-ios-pulse-strong"></span> Popular</a></li>
                <li><a href="/explore/new"<?php if(Input::get('page') === 'new'): ?> class="active active-gold"<?php endif; ?>><span class="ion-android-time"></span> Recent</a></li>
            </ul>
        </div> 
    </div>

    <?php if(Input::get('page') === 'new'): ?>
    <div class="tab-subheader-explore-inner">
        <div class="container">
            <h1>Discover the latest.</h1>
        </div>
    </div>
    <?php else: ?>
    <div class="tab-subheader-explore-inner">
        <div class="container">
            <h1>See what's trending.</h1>
        </div>
    </div>
    <?php endif; ?>
</header>

<section class="main">
    <div class="main-content bg-fix clearfix">
        <div class="container">
            <div class="content-sidebar float-right">
                <?php
                echo sidebarDonate();
                echo sidebarPopular();
                echo sidebarAd();
                ?>
            </div>

            <div class="content-main">
                <?php
                if(Input::get('page') === 'new') {
                    ?>
                    <div class="posts"></div>

                    <?php if($latestPostsCount >= 15): ?><a href="" class="posts-load button"><span class="ion-loop"></span> Load more</a><?php endif; ?>

                    <script>
                        loadmore('/ajax/posts?type=latest');
                    </script>
                    <?php
                } else {
                    ?>
                    <div class="posts"></div>

                    <?php if($popularPostsCount >= 15): ?><a href="" class="posts-load button"><span class="ion-loop"></span> Load more</a><?php endif; ?>

                    <script>
                        loadmore('/ajax/posts?type=popular');
                    </script>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</section>