<header class="tab-subheader">
    <div class="tab-subheader-inner clearfix">
        <div class="container">
            <ul>
                <li><a href="/moderator" class="active">Moderator</a></li>
            </ul>
        </div>
    </div>
</header>

<section class="main">
    <div class="main-content bg-fix clearfix">
        <div class="container">
        
            <div class="account">
                <div class="account-left">
                    <div class="menu-panel slate">
                        <ul>
                            <li>
                                <a href="<?php echo APP_URL; ?>moderator">
                                    <span class="icon ion-home"></span> Home
                                    <span class="float-right"><span class="ion-chevron-right"></span></span>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="menu-panel slate">
                        <ul>
                            <li>
                                <a href="<?php echo APP_URL; ?>moderator/reported-posts">
                                    <span class="icon ion-flag"></span> Reported Posts
                                    <span class="float-right"><?php if($moderator->getUnactedReports('posts') > 0) { ?><span class="tag tag-red"><?php echo $moderator->getUnactedReports('posts'); ?></span>&nbsp;&nbsp; <?php } ?><span class="ion-chevron-right"></span></span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo APP_URL; ?>moderator/reported-comments">
                                    <span class="icon ion-flag"></span> Reported Comments
                                    <span class="float-right"><?php if($moderator->getUnactedReports('comments') > 0) { ?><span class="tag tag-red"><?php echo $moderator->getUnactedReports('comments'); ?></span>&nbsp;&nbsp; <?php } ?><span class="ion-chevron-right"></span></span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo APP_URL; ?>moderator/reported-users">
                                    <span class="icon ion-flag"></span> Reported Users
                                    <span class="float-right"><?php if($moderator->getUnactedReports('users') > 0) { ?><span class="tag tag-red"><?php echo $moderator->getUnactedReports('users'); ?></span>&nbsp;&nbsp; <?php } ?><span class="ion-chevron-right"></span></span>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="menu-panel slate">
                        <ul>
                            <li>
                                <a href="<?php echo APP_URL; ?>moderator/manage" class="selected">
                                    <span class="icon ion-person-stalker"></span> Manage Users
                                    <span class="float-right"><span class="ion-chevron-right"></span></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="account-right">
                    <div class="account-inner slate">
                        <h1>Manage Users</h1>
                        <p class="text-blue"><span class="ion-information-circled"></span> You can complete multiple actions at once. Simply leave the fields blank of any actions you <strong>don't</strong> want to take.</p>
                        <br>

                        <form action="" method="post">
                            <div>
                                <div class="field inline-block">
                                    <label for="suspend">Suspend User</label>
                                    <input type="text" name="suspend" class="input input-text" id="suspend" style="width:200px" placeholder="Enter Username">
                                </div>

                                <div class="field inline-block">
                                    <label for="unsuspend">Unsuspend User</label>
                                    <input type="text" name="unsuspend" class="input input-text" id="unsuspend" style="width:200px" placeholder="Enter Username">
                                </div>
                            </div>

                            <div>
                                <div class="field inline-block">
                                    <label for="verify">Verify User</label>
                                    <input type="text" name="verify" class="input input-text" id="verify" style="width:200px" placeholder="Temporarily Unavailable" disabled>
                                </div>

                                <div class="field inline-block">
                                    <label for="unverify">Unverify User</label>
                                    <input type="text" name="unverify" class="input input-text" id="unverify" style="width:200px" placeholder="Enter Username">
                                </div>
                            </div>

                            <input type="submit" class="button button-success" value="Submit">
                            <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>