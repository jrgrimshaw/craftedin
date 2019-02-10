<?php
require_once dirname(__FILE__) . '/app/init.php';

if(!$user->isLoggedIn()) {
    Redirect::to('/login?return_to=/account/plus');
}

$customer = Stripe_Customer::retrieve($user->data()->customer_id);
$subscription = $customer->subscriptions->retrieve($user->data()->subscription_id);
$subscription->cancel(array('at_period_end' => true));

Redirect::to('/account/plus');