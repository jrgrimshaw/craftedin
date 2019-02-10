<?php
require_once dirname(__FILE__) . '/app/init.php';

if(!$user->isLoggedIn()) {
    Redirect::to('/');
}

if(isset($_POST['stripeToken'])) {
    try {
        $customer = Stripe_Customer::create(array(
            'card'  => $_POST['stripeToken'],
            'email' => escape($user->data()->email),
            'plan'  => 'plus'
        ));

        $user->update(array(
            'plus_until' => $customer->subscriptions->data[0]->current_period_end,
            'customer_id' => $customer->id,
            'subscription_id' => $customer->subscriptions->data[0]->id
        ));

        Redirect::to('/account/plus');
    } catch (Exception $e) {
        echo $error = $e->getMessage();
    }
} else {
    echo 'Invalid Request.';
}