<section class="main">
    <div class="premium">
        <div class="premium-hero bg-fix">
            <div class="hero-logo"></div>
        </div>

        <div class="main-content bg-fix clearfix">
            <div class="container">
                <div class="premium-inner slate">
                    <div class="inner-row clearfix">
                        <div class="float-left">
                            <img src="<?php echo STATIC_URL . 'images/premium/marketing/one.jpg' ?>" alt="No Ads">
                        </div>
                        <div>
                            <p class="title">No Ads</p>
                            <p>Hate ads? All ads that free users see will suddenly vanish into thin air with CraftedIn Premium.</p>
                        </div>
                    </div>
                    <div class="inner-row clearfix">
                        <div class="float-left">
                            <img src="<?php echo STATIC_URL . 'images/premium/marketing/two.jpg' ?>" alt="Customise Your Profile">
                        </div>
                        <div>
                            <p class="title">Customise Your Profile</p>
                            <p>Don't leave your profile looking stock. With CraftedIn Premium you can add an awesome header picture and creatively express yourself.</p>
                        </div>
                    </div>
                    <div class="inner-row clearfix">
                        <div class="float-left">
                            <img src="<?php echo STATIC_URL . 'images/premium/marketing/three.jpg' ?>" alt="An Awesome Profile Badge">
                        </div>
                        <div>
                            <p class="title">An Awesome Profile Badge</p>
                            <p>Show your support for CraftedIn while rocking an awesome badge on your CraftedIn profile. Your profile will have never looked better.</p>
                        </div>
                    </div>
                    <div class="inner-row clearfix">
                        <div class="float-left">
                            <img src="<?php echo STATIC_URL . 'images/premium/marketing/four.jpg' ?>" alt="Look Better">
                        </div>
                        <div>
                            <p class="title">Look Better</p>
                            <p>Show the CraftedIn community that what you're about. CraftedIn Premium shows your job next to your name on every post.</p>
                        </div>
                    </div>
                    <div class="inner-row clearfix">
                        <div class="float-left">
                            <img src="<?php echo STATIC_URL . 'images/premium/marketing/five.jpg' ?>" alt="Unlimited Websites">
                        </div>
                        <div>
                            <p class="title">Unlimited Websites</p>
                            <p>Own more than 2 websites? Show them all off with unlimited websites standard with CraftedIn Premium.</p>
                        </div>
                    </div>
<!--                     <div class="inner-row clearfix">
                        <div class="float-left">
                            <img src="<?php echo STATIC_URL . 'images/premium/marketing/six.jpg' ?>" alt="Find a Job">
                        </div>
                        <div>
                            <p class="title">Find a Job</p>
                            <p>Finding a job these days isn't always easy. Show CraftedIn your amazing talent, and then make it easy for potential employers to hire you.</p>
                        </div>
                    </div> -->
                    <div class="inner-row clearfix">
                        <div class="float-left">
                            <img src="<?php echo STATIC_URL . 'images/premium/marketing/seven.jpg' ?>" alt="Help the World">
                        </div>
                        <div>
                            <p class="title">Help the World</p>
                            <p>CraftedIn Premium doesn't just help you. It helps the world. 10% of your monthly subscription goes straight to Oxfam. <a href="/charity" target="_blank">Learn More <span class="ion-android-arrow-dropright"></span></a></p>
                        </div>
                    </div>
                    <div class="inner-row clearfix">
                        <div class="float-left">
                            <img src="<?php echo STATIC_URL . 'images/premium/marketing/eight.jpg' ?>" alt="Priority Support">
                        </div>
                        <div>
                            <p class="title">Priority Support</p>
                            <p>The finest priority support from CraftedIn comes standard with all premium accounts.</p>
                        </div>
                    </div>
                    <div class="inner-row clearfix">
                        <p class="ready">Plus much, much more. Get started with premium today.</p>

                        <form action="/premium/charge" method="post">
                            <button class="button button-success button-large wide" id="customButton">Subscribe Now (£5/month)</button>
                        </form>
                    </div>
                </div>
                
                <script>
                    $('#customButton').click(function() {
                        var token = function(res) {
                            var $input = $('<input type="hidden" name="stripeToken">').val(res.id);
                            $('form').append($input).submit();
                        };

                        StripeCheckout.open({
                            key:            '<?php echo $stripe['publishable']; ?>',
                            amount:         500,
                            currency:       'gbp',
                            name:           'CraftedIn',
                            description:    'Premium (1 Month)',
                            panelLabel:     'Subscribe',
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