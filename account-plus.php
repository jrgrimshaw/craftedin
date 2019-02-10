<?php
require_once dirname(__FILE__) . '/app/init.php';

if(!$user->isLoggedIn()) {
    Redirect::to('/login?return_to=/account/plus');
}

if(!$user->isPremium()) {
    Redirect::to('/plus');
}

if($user->isPremium()) {
    if(!empty($user->data()->customer_id) && !empty($user->data()->subscription_id)) {
        $customer = Stripe_Customer::retrieve($user->data()->customer_id);
        $subscription = $customer->subscriptions->retrieve($user->data()->subscription_id);
        $card_id = $customer->default_card;
        $card = $customer->cards->retrieve($card_id);
    }
}

$title = 'Account - Plus';
$content = 'account-plus';

require_once dirname(__FILE__) . '/app/views/view.php';