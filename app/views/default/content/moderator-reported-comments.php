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
                                <a href="<?php echo APP_URL; ?>moderator/reported-comments" class="selected">
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
                        <h1>Reported Comments</h1>

                        <div class="moderator-table">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="id">Report ID</th>
                                        <th class="content">Content</th> 
                                        <th class="date">Date Reported</th>
                                        <th class="actions">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                if($moderator->getUnactedReports('comments')):
                                    foreach($moderator->displayUnactedReports('comments')->results() as $m):
                                    ?>
                                    <tr>
                                        <td class="id"><?php echo $m->id; ?></td>
                                        <td class="content"><a href="/post/<?php echo $comment->get($m->content_id)->post_id; ?>" target="_blank"><span class="text-grey">(Comment ID: <?php echo $m->content_id; ?>)</span> "<?php echo substr($comment->get($m->content_id)->content, 0, 40); ?>..." <span class="text-grey">(Click to view)</span></a></td>
                                        <td class="date"><abbr class="timeago" title="<?php echo date(DATE_ISO8601, strtotime($m->date)); ?>"></td>
                                        <td class="actions"><a href="/moderator/approve?report_id=<?php echo $m->id; ?>&type=comments" class="text-green">Approve Comment</a><br><a href="/moderator/remove?report_id=<?php echo $m->id; ?>&content_id=<?php echo $m->content_id; ?>&type=comments" class="text-red">Delete Comment</a></td>
                                    </tr>
                                    <?php
                                    endforeach;
                                else:
                                ?>
                                    <tr class="no-messages">
                                        <td colspan="4">
                                            <div class="icon ion-happy-outline"></div>
                                            <div class="message">Awesome! There are currently no new reports.</div>
                                        </td>
                                    </tr>
                                <?php
                                endif;
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>