<?php

namespace App\Http\Controllers;

use Stripe\Charge;
use App\Models\Subscription;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    public function store(Request $request, Subscription $subscription)
    {

        $stripe = new \Stripe\StripeClient(config('services.stripe.secret_key'));
        $stripe->charges->create([

            'amount' => $subscription->price * 100,
            'currency' => 'usd',
            'source' => $subscription->id,
            'description' => 'My First Test Charge (created for API docs at )',
        ]);

        \Stripe\Stripe::setApiKey(config('services.stripe.secret_key'));


        $checkout_session = Charge::create([

            'mode' => 'setup',
            'client_reference_id' => $subscription->id,
            'customer_email' => $subscription->user->email,
            'success_url' => route('payments.success'),
            'cancel_url' => route('payments.cancel'),
        ]);
    }

    public function success(Request $request)
    {
    }
    public function cancel(Request $request)
    {
    }
}
