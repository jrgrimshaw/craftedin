<?php
function sidebarPremium() {
    ob_start();
    ?>
    <div class="sidebar-widget">
        <div class="widget-body widget-no-padding">
            <a href="/plus?ref=plus-ad"><img src="<?php echo STATIC_URL; ?>images/external/plus-ad.jpg"></a>
        </div>
    </div>
    <?php
    $html = ob_get_contents();
    ob_end_clean();

    return $html;
}

function sidebarWtf($user) {
    ob_start();
    if(!$user->whoToFollow()->count()):
    else:
    ?>
    <div class="sidebar-widget">
        <div class="widget-header">
            <h3>
                <span class="icon ion-person-add"></span> Who to follow
                <a href="javascript:location.reload()"><span class="float-right ion-android-sync"></span></a>
            </h3>
        </div>

        <div class="widget-body clearfix">
            <div class="widget-users">
                <ul>
                <?php
                foreach($user->whoToFollow()->results() as $data):
                    ?>
                        <li>
                            <div class="user-image">
                                <img src="<?php echo USER_AVATAR_DIR . $data->avatar; ?>" alt="<?php echo escape($data->name); ?>">
                            </div>

                            <div class="user-info">
                                <div class="float-left">
                                    <div class="name"><a href="<?php if($data->page): echo '/page/'; else: echo '/user/'; endif; echo escape($data->username); ?>" class="user-link"><?php echo substr(escape($data->name), 0, 19); ?> <?php if($data->verified): ?><span class="user-verified"><span class="ion-checkmark-circled"></span></span><?php endif; ?></a></div>
                                    <div class="username">@<?php echo escape($data->username); ?></div>
                                </div>
                                <div class="float-right">
                                    <div class="follow"><a href="/ajax/follow?user_id=<?php echo $data->id; ?>" class="button button-success button-small follow-button"><span class="ion-person-add"></span><span class="follow-button-text">Follow</span></a></div>
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
    <?php
    endif;
    $html = ob_get_contents();
    ob_end_clean();

    return $html;
}

function sidebarPopular() {
    ob_start();
    ?>
    <div class="sidebar-widget">
        <div class="widget-header">
            <h3>
                <span class="icon ion-arrow-graph-up-right"></span> Trends
                <a href="javascript:location.reload()"><span class="float-right ion-android-sync"></span></a>
            </h3>
        </div>

        <div class="widget-body clearfix">
            <div class="widget-popular">
                <ul>
                <?php
                foreach(Hashmention::displayHashtags() as $data):
                ?>
                    <li><a href="/search?q=<?php echo urlencode(escape($data->name)); ?>"><?php echo escape($data->name); ?></a> <span class="float-right"><?php echo $data->posted; ?></span></li>
                <?php
                endforeach;
                ?>
                </ul>
            </div>
        </div>
    </div>
    <?php
    $html = ob_get_contents();
    ob_end_clean();

    return $html;
}

function sidebarAd() {
    ob_start();
    ?>
    <div class="sidebar-widget">
        <div class="widget-body widget-no-padding">
            <script async type="text/javascript" src="//cdn.carbonads.com/carbon.js?zoneid=1673&serve=C6AILKT&placement=craftedinco" id="_carbonads_js"></script>
        </div>
    </div>
    <?php
    $html = ob_get_contents();
    ob_end_clean();

    return $html;
}

function sidebarTotd() {
    ob_start();
    ?>
    <div class="sidebar-widget widget-green">
        <div class="widget-header">
            <h3>
                <span class="ion-android-bulb"></span> What's New
            </h3>
        </div>

        <div class="widget-body clearfix">
            <div class="widget-totd">
                <a href="/blog/changelog/911.txt" class="button button-success wide">See what's new in 9.1.1</a>
                <p><a href="https://craftedin.co/messages/compose?t=james&s=Update%20Feedback"><span class="ion-flag"></span> Have feedback or ideas for an update?</a></p>
            </div>
        </div>
    </div>
    <?php
    $html = ob_get_contents();
    ob_end_clean();

    return $html;
}

function sidebarDonate() {
    ob_start();
    ?>
    <div class="sidebar-widget">
        <div class="widget-header">
            <h3>
                <span class="ion-heart"></span> CraftedIn Beta Fund
            </h3>
        </div>

        <div class="widget-body clearfix">
            <div class="widget-donate">
                <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                    <input type="hidden" name="cmd" value="_s-xclick">
                    <input type="hidden" name="hosted_button_id" value="RLZWEG3K2SH6Q">
                    <input type="submit" value="Donate" class="button button-gold wide" alt="PayPal – The safer, easier way to pay online!">
                    <img alt="" border="0" src="https://www.paypalobjects.com/en_GB/i/scr/pixel.gif" width="1" height="1">
                </form>
                <p>Donations processed securely through <a href="https://www.paypal.com">PayPal</a></p>
            </div>
        </div>
    </div>
    <?php
    $html = ob_get_contents();
    ob_end_clean();

    return $html;
}