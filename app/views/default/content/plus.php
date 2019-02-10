<section class="main">
    <div class="plus">
        <div class="plus-hero bg-fix">
            <span class="hero-logo animated fadeIn">Plus</span>
        </div>

        <div class="plus-main main-content bg-fix clearfix">
            <div class="container">
            <div class="marketing exclusive-slate slate">
                    <div class="marketing-point clearfix">
                        <div class="marketing-point-text exclusive">
                            <h2><span class="ion-ios-star-outline"></span> The exclusive club</h2>
                            <p>Welcome to CraftedIn Plus. The exclusive club for members looking to support CraftedIn's growth and get the full experience.</p>
                        </div>
                    </div>
            </div>

                <div class="marketing slate">
                    <div class="marketing-point clearfix">
                        <div class="marketing-point-image float-right">
                            <img src="<?php echo STATIC_URL; ?>images/plus/adfree.jpg" alt="">
                        </div>
                        <div class="marketing-point-text">
                            <h2>Ad-Free</h2>
                            <p>CraftedIn Plus users get absolutely no adverts whatsoever. Focus on the content - browse CraftedIn clutter free and feel the fresh air.</p>
                        </div>
                    </div>
                    <div class="marketing-point clearfix">
                        <div class="marketing-point-image float-right">
                            <img src="<?php echo STATIC_URL; ?>images/plus/badge.jpg" alt="">
                        </div>
                        <div class="marketing-point-text">
                            <h2>Badge</h2>
                            <p>Show everyone how Plus you are with an awesome new badge on your profile - while showing that you're supporting the growth of CraftedIn.</p>
                        </div>
                    </div>
                    <div class="marketing-point clearfix">
                        <div class="marketing-point-image float-right">
                            <img src="<?php echo STATIC_URL; ?>images/plus/websites.jpg" alt="">
                        </div>
                        <div class="marketing-point-text">
                            <h2>Showcase unlimited websites</h2>
                            <p>CraftedIn Plus members can submit unlimited websites to the showcase. Stop just showing off your best work and show it all off with CraftedIn Plus.</p>
                        </div>
                    </div>
                    <div class="marketing-point clearfix">
                        <div class="marketing-point-image float-right">
                            <img src="<?php echo STATIC_URL; ?>images/plus/work.jpg" alt="">
                        </div>
                        <div class="marketing-point-text">
                            <h2>Find Work</h2>
                            <p>Are you or your team looking for a project or job? With CraftedIn Plus, you can display a 'For Hire' badge on your profile. Finding work has never been this easy.</p>
                        </div>
                    </div>
                    <div class="marketing-point clearfix">
                        <div class="marketing-point-image float-right">
                            <img src="<?php echo STATIC_URL; ?>images/plus/support.jpg" alt="">
                        </div>
                        <div class="marketing-point-text">
                            <h2>Priority Support</h2>
                            <p>If all of the above isn't enough, the finest priority support from CraftedIn comes standard with all premium accounts.</p>
                        </div>
                    </div>
                </div>

                <div class="marketing slate">
                    <div class="marketing-point clearfix">
                        <div class="marketing-point-text">
                            <h2><span class="ion-star"></span> Be Part of History</h2>
                            <p> We want to thank CraftedIn Plus members for supporting us as we grow. For a limited time only, new CraftedIn Plus members will have their names published on CraftedIn's <a href="/thanks">thanks page</a>.</p>
                        </div>
                    </div>
                    <div class="marketing-point marketing-point-red clearfix">
                        <div class="marketing-point-image float-right">
                            <img src="<?php echo STATIC_URL; ?>images/plus/charity.jpg" alt="">
                        </div>
                        <div class="marketing-point-text">
                            <h2><span class="ion-star"></span> More than features</h2>
                            <p><strong>10%</strong> of your yearly CraftedIn bill goes directly to our charity of the year <a href="https://www.bhf.org.uk">(British Heart Foundation)</a>, so there's another reason to feel awesome while you rock CraftedIn Plus.</p>
                        </div>
                    </div>
                </div>

                <div class="marketing upgrade slate">
                    <h2>Just £19.99/yr GBP</h2>
                    <p>Billed yearly. Plus starts immediately after upgrading. Payments are handled by <a href="https://stripe.com" target="_blank">Stripe</a>, and don't touch our servers.</p>

                    <form action="/premium/charge" method="post">
                        <button class="button button-success button-large" id="customButton">Ready? Upgrade Now</button>
                    </form>
                    <p></p>
                </div>

                <script>
                    $('#customButton').click(function() {
                        var token = function(res) {
                            var $input = $('<input type="hidden" name="stripeToken">').val(res.id);
                            $('form').append($input).submit();
                        };

                        StripeCheckout.open({
                            key:            '<?php echo $stripe['publishable']; ?>',
                            amount:         1999,
                            currency:       'gbp',
                            name:           'CraftedIn Plus',
                            description:    'Yearly Subscription',
                            panelLabel:     'Upgrade',
                            email:          '<?php echo escape($user->data()->email); ?>',
                            image:          '<?php echo STATIC_URL . 'images/logo/stripe-logo.png'; ?>',
                            token:          token
                        });

                        return false;
                    });
                </script>
            </div>
        </div>
    </div>
</section>