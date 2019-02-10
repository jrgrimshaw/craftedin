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
                                <a href="<?php echo APP_URL; ?>moderator" class="selected">
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
                                <a href="<?php echo APP_URL; ?>moderator/manage">
                                    <span class="icon ion-person-stalker"></span> Manage Users
                                    <span class="float-right"><span class="ion-chevron-right"></span></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="account-right">
                    <div class="account-inner slate">
                        <h1>Welcome</h1>

                        <p>Welcome to the CraftedIn Moderator panel. This is an extremely exclusive privilege, and actions taken on here must be taken extremely seriously. Prior to beoming a moderator, you agreed to a set of rules, and there is also a set of guidelines to help you make decisions. All of these documents can be found below for referral. <em>Simply be sensible, make fair and unbiased decisions and help keep CraftedIn spam free and an enjoyable experience for everyone.</em></p>
                        <br>

                        <p><strong>Contact</strong></p>
                        <p>If there is a problem and you need to contact someone, please contact one of the following people - they will sort your issue as soon as possible.</p>
                        <p class="text-grey">James Grimshaw (Founder/Lead Developer) &nbsp; [Mobile] <a href="tel:(+44)7490459984">(+44) 7490 459984 (United Kingdom)</a> &nbsp; [Email] <a href="mailto:james@jgrimshaw.com">james@jgrimshaw.com</a></p>
                        <p class="text-grey">Marcus Christensen (Co-Founder/Ops) &nbsp; [Mobile] <a href="tel:(+45)22405420">(+45) 22 40 5420 (Denmark)</a> &nbsp; [Email] <a href="mailto:marcus@jgrimshaw.com">marcus@jgrimshaw.com</a></p>
                        <br>

                        <p><strong>Reference Document Library</strong></p>
                        <p>Important documents relating to your role as moderator. (Coming soon)</p>
                        <p><a href="#">[PDF] The Moderator Agreement</a></p>
                        <p><a href="#">[PDF] Rules & Guidelines</a></p>
                        <br>

                        <p class="text-grey"><em>Version &beta;1.1</em></p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>