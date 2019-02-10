<?php
require_once dirname(__FILE__) . '/app/init.php';

// Retrieve the request's body and parse it as JSON
$input = @file_get_contents("php://input");
$event_json = json_decode($input);

$event_id = $event_json->id;

// to verify this is a real event, we re-retrieve the event from Stripe 
$event = Stripe_Event::retrieve($event_id);
$data = $event->data->object;

if($event->type === 'customer.subscription.updated') {
    $customer = Stripe_Customer::retrieve($data->customer);
    $plus_until = $data->current_period_end;
    $user_id = DB::getInstance()->get('users', array('customer_id', '=', $data->customer))->first()->id;
    $user->update(array(
        'plus_until' => $plus_until
    ), $user_id);

    echo 'customer.subscription.updated success';
}

if($event->type === 'customer.subscription.deleted') {
    $customer = Stripe_Customer::retrieve($data->customer);
    $plus_until = $data->current_period_end;
    $user_id = DB::getInstance()->get('users', array('customer_id', '=', $data->customer))->first()->id;
    $user->update(array(
        'plus_until' => null,
        'customer_id' => null,
        'subscription_id' => null
    ), $user_id);

    echo 'customer.subscription.deleted success';
}

// webhook response
http_response_code(200);