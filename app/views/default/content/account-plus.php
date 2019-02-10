<section class="main">
    <div class="main-content bg-fix clearfix">
        <div class="container">
        
            <div class="account">
                <div class="account-left">
                    <?php $pageSelected = 'plus'; require_once 'includes/account-sidebar.php'; ?>
                </div>

                <div class="account-right">
                    <div class="account-inner slate">
                        <h1>Plus</h1>

                        <div class="manage-premium">
                            <div class="status">
                            <?php if(!empty($user->data()->customer_id) && !empty($user->data()->subscription_id)): ?>
                                <?php if(!$subscription->cancel_at_period_end): ?>
                                    You are currently a CraftedIn Plus subscriber. You will be automatically billed again on the <?php echo date("dS F Y \a\\t h:ia", $user->data()->plus_until); ?>.
                                <?php else: ?>
                                    Your CraftedIn Plus subscription will end on the <?php echo date("dS F Y \a\\t h:ia", $user->data()->plus_until); ?> and you will not be automatically billed again.
                                <?php endif; ?>
                            <?php else: ?>
                                Your CraftedIn Plus membership does not have a card associated with it. Your subscription runs out on the <?php echo date("dS F Y \a\\t h:ia", $user->data()->plus_until); ?>.
                            <?php endif; ?>
                            </div>

                            <?php if(!empty($user->data()->customer_id) && !empty($user->data()->subscription_id)): ?>
                            <!-- See current card details -->
                            <div class="details">
                                <h2>Details</h2>
                                
                                <div class="clearfix">
                                    <div class="float-left">
                                        <span class="ion-card"></span>
                                    </div>
                                    <div>
                                        <p class="card-number">**** **** **** <?php echo $card->last4; ?></p>
                                        <p>Brand: <?php echo $card->brand . ' ' . $card->funding; ?></p>
                                        <p>Expires: <?php echo $card->exp_month . '/' . $card->exp_year; ?></p>
                                    </div>
                                </div>

                                <?php if(!$subscription->cancel_at_period_end): ?>
                                    <a href="/premium/cancel" class="button button-warning button-small">Cancel Subscription</a>
                                <?php else: ?>
                                    <a class="button button-boring button-small">Subscription Cancelled</a>
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>

                            <div class="manage-premium-footer text-grey">
                                Payments are securely processed using <a href="https://stripe.com" target="_blank">Stripe</a>. We don't store any credit or debit card details. In fact, your details never touch our servers.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>