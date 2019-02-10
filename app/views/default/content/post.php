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
                <div class="stream">
                    <?php echo streamPost($data, $user, $comment, $allComments = true); ?>
                </div>
            </div>
        </div>
    </div>
</section>