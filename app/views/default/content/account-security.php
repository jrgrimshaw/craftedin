<section class="main">
    <div class="main-content bg-fix clearfix">
        <div class="container">
        
            <div class="account">
                <div class="account-left">
                    <?php $pageSelected = 'sessions'; require_once 'includes/account-sidebar.php'; ?>
                </div>

                <div class="account-right">
                    <div class="account-inner slate">
                        <h1>Security</h1>

                        <div class="sessions">
                        <?php foreach($data as $d) { $geo->request($d->ip); $ua->request($d->user_agent); ?>
                            <div class="session <?php if($d->hash === Cookie::get(Config::get('remember/cookie_name'))): ?>current-session<?php endif; ?>">
                                <?php if($d->hash === Cookie::get(Config::get('remember/cookie_name'))): ?><p class="current">Current Session</p><?php endif; ?>
                                <div class="session-inner clearfix">
                                    <div class="float-left">
                                        <p><strong>Location:</strong> <?php echo $geo->cityName . ', ' . $geo->regionName . ', ' . $geo->countryName . ' <span class="text-grey">(Approximate)</span>'; ?></p>
                                        <p><strong>Device:</strong> <?php echo $ua->agent_name . ' on ' . $ua->os_name; ?></p>
                                        <p><strong>Date:</strong> <?php echo date("jS F Y \a\\t H:ia", strtotime($d->date)); ?></p>
                                    </div>
                                    <div class="float-right">
                                        <?php if($d->hash !== Cookie::get(Config::get('remember/cookie_name'))): ?><a href="?rl=<?php echo $d->id; ?>" class="button button-warning button-tiny"><span class="ion-close-circled">&nbsp;</span> End Session</a><?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>